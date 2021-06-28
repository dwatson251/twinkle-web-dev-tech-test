<?php

namespace Twinkl\Core\TemplateBuilder\LeaguePlates;

use Exception;
use InvalidArgumentException;
use LogicException;
use League\Plates\Engine;
use League\Plates\Template\{Folder, Folders, Func};
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Consts\TemplateConsts;
use Twinkl\Core\Helper\EvalExt\EvalHelper;
use Twinkl\Core\TemplateBuilder\BaseTemplateBuilder;

/**
 * Class LeaguePlatesTemplateBuilder
 * @package Twinkl\Core\TemplateBuilder\LeaguePlates
 */
class LeaguePlatesTemplateBuilder extends BaseTemplateBuilder
{
    /*
     * Consts
     */
    
    public const DIR_DEFAULT = TemplateConsts::DIR_VIEWS;
    public const FILE_EXT_DEFAULT = TemplateConsts::FILE_EXT;
    public const FLDS_DEFAULT = [];
    
    /*
     * Properties
     */
    
    /**
     * @var Engine|null
     */
    protected $client;
    
    /*
     * Init logic
     */
    
    /**
     * LeaguePlatesTemplateBuilder constructor.
     * @param Engine|null $client
     * @param string|null $templateName
     * @param array|null $config
     */
    public function __construct(
        Engine $client = null,
        string $templateName = null,
        array $config = null
    ) {
        parent::__construct($templateName, $config);
        $this->setClient($client);
    }
    
    /**
     * @return $this
     */
    public function init()
    {
        $this->client = $this->createClient();
        $this
            ->initDirectory()
            ->initFileExt()
            ->initFolders();
        return $this;
    }
    
    /*
     * Client logic
     */
    
    /**
     * @return Engine|null
     */
    public function getClient()
    {
        return $this->client;
    }
    
    /**
     * @param Engine|null $client
     * @return $this
     */
    public function setClient(?Engine $client)
    {
        $this->client = $client;
        return $this;
    }
    
    /**
     * @param string|null $dir
     * @param string|null $fileExt
     * @return Engine
     */
    public function createClient(string $dir = null, string $fileExt = null)
    {
        return new Engine($dir, $fileExt);
    }
    
    /**
     * @param bool $triggerEx
     * @return bool
     */
    protected function checkIssetClient(bool $triggerEx = true)
    {
        if (!$this->client) {
            if ($triggerEx) {
                throw new LogicException('Template builder client is not defined!');
            }
            return false;
        }
        return true;
    }
    
    /*
     * Directory logic
     */
    
    /**
     * @return $this
     * @throws Exception
     */
    protected function initDirectory()
    {
        $this->client->setDirectory(static::DIR_DEFAULT);
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getDirectory()
    {
        return $this->client ? $this->client->getDirectory() : null;
    }
    
    /**
     * @param string|null $dir
     * @return $this
     * @throws Exception
     */
    public function setDirectory(?string $dir)
    {
        $this->checkIssetClient();
        $this->client->setDirectory($dir);
        return $this;
    }
    
    /*
     * File ext logic
     */
    
    /**
     * @return $this
     * @throws Exception
     */
    protected function initFileExt()
    {
        $this->client->setFileExtension(static::FILE_EXT_DEFAULT);
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getFileExt()
    {
        return $this->client ? $this->client->getFileExtension() : null;
    }
    
    /**
     * @param string|null $fileExt
     * @return $this
     * @throws Exception
     */
    public function setFileExt(?string $fileExt)
    {
        $this->checkIssetClient();
        $this->fileExt = $fileExt;
        return $this;
    }
    
    /*
     * Folders logic
     */
    
    /**
     * @return $this
     * @throws Exception
     */
    protected function initFolders()
    {
        if (!empty(static::FLDS_DEFAULT)) {
            $this->addFolders(static::FLDS_DEFAULT);
        }
        return $this;
    }
    
    /**
     * @return Folders|null
     */
    public function getFolders()
    {
        return $this->client ? $this->client->getFolders() : null;
    }
    
    /**
     * @param string[] $names
     * @return Folder[]
     */
    public function getFoldersAllAt(array $names)
    {
        return array_reduce(
            array_filter($names),
            function ($carry, $iName) {
                $carry[$iName] = $this->getFolder($iName);
                return $carry;
            },
            []
        );
    }
    
    /**
     * @param string $name
     * @return Folder|null
     */
    public function getFolder(string $name)
    {
        try {
            return $this->getFolders()->get($name);
        } catch (Exception $ex) {
            return null;
        }
    }
    
    /**
     * @param array $flds
     * @param string|null $dir
     * @param bool|null $fallback
     * @return $this
     * @throws Exception
     */
    public function addFolders(array $flds, string $dir = null, bool $fallback = null)
    {
        $dir = $dir ?? $this->getDirectory();
        $fallback = $fallback ?? false;
        foreach (array_filter($flds) as $iDir => $iFld) {
            $iFld = $this->parseFolder(
                $iFld,
                is_string($iDir) ? $iDir : $dir,
                $fallback
            );
            $this->addFolder(
                $iFld->getName(),
                $iFld->getPath(),
                $iFld->getFallback()
            );
        }
        return $this;
    }
    
    /**
     * @param string $name
     * @param string|null $dir
     * @param bool|null $fallback
     * @return $this
     */
    public function addFolder(string $name, string $dir = null, bool $fallback = null)
    {
        if (trim($name) === '') {
            throw new InvalidArgumentException(
                'Folder name not defined!',
                HttpConsts::CODE_SERVER_ERROR
            );
        }
        $dir = $dir ?? $this->getDirectory();
        if (trim($dir) === '') {
            throw new InvalidArgumentException(
                'Directory is not defined!',
                HttpConsts::CODE_SERVER_ERROR
            );
        }
        if (!is_dir($dir)) {
            throw new LogicException(
                'Directory does not exist!',
                HttpConsts::CODE_SERVER_ERROR
            );
        }
        try {
            $this->client->addFolder(
                $name,
                $dir ?? $this->getDirectory(),
                $fallback ?? false
            );
        } catch (Exception $ex) { }
        return $this;
    }
    
    /**
     * @param string[] $names
     * @return $this
     */
    public function removeFoldersAllAt(array $names)
    {
        foreach (array_filter($names) as $iName) {
            $this->removeFolder($iName);
        }
        return $this;
    }
    
    /**
     * @param string $name
     * @return $this
     */
    public function removeFolder(string $name)
    {
        try {
            $this->client->removeFolder($name);
        } catch (Exception $ex) { }
        return $this;
    }
    
    /**
     * @param mixed|Folder $fld
     * @param string|null $dir
     * @param bool|null $fallback
     * @return Folder|null
     */
    public function parseFolder($fld, string $dir = null, bool $fallback = null): ?Folder
    {
        if ($fld === null) {
            return null;
        }
        $dir = $dir ?? $this->getDirectory();
        $fallback = $fallback ?? false;
        if (!($fld instanceof Folder)) {
            if (is_array($fld)) {
                $fld = new Folder(
                    $fld['name'] ?? null,
                    $fld['dir'] ?? $dir,
                    (bool) ($fld['fallback'] ?? $fallback)
                );
            } else {
                $fld = new Folder($fld, $dir, $fallback);
            }
        }
        return $fld;
    }
    
    /**
     * @param string $name
     * @param string|null $dir
     * @param bool|null $fallback
     * @return bool
     * @throws Exception
     */
    public function validateFolder(string $name, string $dir = null)
    {
        if (trim($name) === '') {
            throw new InvalidArgumentException(
                'Folder name not defined!',
                HttpConsts::CODE_SERVER_ERROR
            );
        }
        $dir = $dir ?? $this->getDirectory();
        if (trim($dir) === '') {
            throw new InvalidArgumentException(
                'Directory is not defined!',
                HttpConsts::CODE_SERVER_ERROR
            );
        }
        if (!is_dir($dir)) {
            throw new LogicException(
                'Directory does not exist!',
                HttpConsts::CODE_SERVER_ERROR
            );
        }
        return true;
    }
    
    /*
     * Function logic
     */
    
    /**
     * @param string[] $names
     * @return mixed|null
     */
    public function getFunctions(array $names)
    {
        return array_reduce(
            array_filter($names),
            function ($carry, $iName) {
                $carry[$iName] = $this->getFunction($iName);
                return $carry;
            },
            []
        );
    }
    
    /**
     * @param string $name
     * @return Func|null
     */
    public function getFunction(string $name)
    {
        try {
            return $this->client->getFunction($name);
        } catch (Exception $ex) {
            return null;
        }
    }
    
    /**
     * @param callable[] $cbs
     * @return $this
     */
    public function addFunctions(array $cbs)
    {
        foreach (array_filter($cbs) as $iCbName => $iCb) {
            $this->addFunction($iCbName, $iCb);
        }
        return $this;
    }
    
    /**
     * @param string $name
     * @param callable $cb
     * @return $this
     */
    public function addFunction(string $name, callable $cb)
    {
        try {
            $this->removeFolder($name);
            $this->client->registerFunction($name, $cb);
        } catch (Exception $ex) { }
        return $this;
    }
    
    /**
     * @param string[] $names
     * @return $this
     */
    public function removeFunctions(array $names)
    {
        foreach (array_filter($names) as $iName) {
            $this->removeFunction($iName);
        }
        return $this;
    }
    
    /**
     * @param string $name
     * @return $this
     */
    public function removeFunction(string $name)
    {
        try {
            $this->client->dropFunction($name);
        } catch (Exception $ex) { }
        return $this;
    }
    
    /*
     * Data logic
     */
    
    /**
     * @param string|null $templateName
     * @return array
     */
    public function getData(string $templateName = null)
    {
        return $this->client->getData($templateName);
    }
    
    /**
     * @param array $data
     * @param array|null $templateNames
     * @return $this
     */
    public function addData(array $data, array $templateNames = null)
    {
        $this->client->addData(
            $data,
            array_filter($templateNames ?? [$this->templateName]) ?: null
        );
        return $this;
    }
    
    /*
     * Render logic
     */
    
    /**
     * @param string|null $templateName
     * @param array|null $data
     * @return string
     */
    public function render(string $templateName = null, array $data = null)
    {
        return $this->client->render(
            $templateName ?? $this->templateName,
            $data ?? []
        );
    }
}