<?php


namespace Twinkl\Core\Util;

use Exception;
use Twinkl\Core\Consts\CssConsts;
use Twinkl\Core\Consts\HtmlConsts;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Consts\JsConsts;
use Twinkl\Core\CustomTrait\SingletonTrait;
use Twinkl\Core\Exception\ExceptionExt;
use Twinkl\Core\Parser\Widget\LinkWidgetParser;
use Twinkl\Core\Parser\Widget\ScriptWidgetParser;
use Twinkl\Core\Widget\Link\CssLinkWidget;
use Twinkl\Core\Widget\Link\LinkWidget;
use Twinkl\Core\Widget\Script\ScriptWidget;

/**
 * Class PageUtils
 * @package Twinkl\Core\Util
 */
class PageUtils
{
    /*
     * Traits
     */
    
    use SingletonTrait;
    
    /*
     * Properties
     */
    
    /**
     * @var ScriptWidget[]
     */
    protected $headerScripts = [];
    /**
     * @var ScriptWidget[]
     */
    protected $footerScripts = [];
    /**
     * @var LinkWidget[]
     */
    protected $headerLinks = [];
    /**
     * @var LinkWidget[]
     */
    protected $footerLinks = [];
    
    /**
     * PageUtils constructor.
     */
    public function __construct()
    {
        $this
            ->addHeaderLink(
                new CssLinkWidget(CssConsts::URI_MAIN)
            )
            ->addFooterScript(JsConsts::URI_MAIN);
    }
    
    /*
     * Scripts logic
     */
    
    /**
     * @return ScriptWidget[]
     */
    public function getHeaderScripts(): array
    {
        return $this->headerScripts;
    }
    
    /**
     * @param array|null $scripts
     * @return $this
     */
    public function setHeaderScripts(?array $scripts)
    {
        $this->headerScripts = [];
        if ($scripts) {
            $this->addHeaderScripts($scripts);
        }
        return $this;
    }
    
    /**
     * @param array $scripts
     * @return $this
     * @throws Exception
     */
    public function addHeaderScripts(array $scripts)
    {
        foreach ($scripts as $iScript) {
            $this->addHeaderScript($iScript);
        }
        return $this;
    }
    
    /**
     * @param mixed $script
     * @return $this
     * @throws Exception
     */
    public function addHeaderScript($script)
    {
        if ($script = $this->parseScript($script)) {
            $this->headerScripts[] = $script;
        }
        return $this;
    }
    
    /**
     * @return ScriptWidget[]
     */
    public function getFooterScripts(): array
    {
        return $this->footerScripts;
    }
    
    /**
     * @param array|null $scripts
     * @return $this
     */
    public function setFooterScripts(?array $scripts)
    {
        $this->footerScripts = [];
        if ($scripts) {
            $this->addFooterScripts($scripts);
        }
        return $this;
    }
    
    /**
     * @param array $scripts
     * @return $this
     * @throws Exception
     */
    public function addFooterScripts(array $scripts)
    {
        foreach ($scripts as $iScript) {
            $this->addFooterScript($iScript);
        }
        return $this;
    }
    
    /**
     * @param mixed $script
     * @return $this
     * @throws Exception
     */
    public function addFooterScript($script)
    {
        if ($script = $this->parseScript($script)) {
            $this->footerScripts[] = $script;
        }
        return $this;
    }
    
    /**
     * @param mixed $script
     * @return ScriptWidget|null
     * @throws Exception
     */
    protected function parseScript($script): ?ScriptWidget
    {
        return (new ScriptWidgetParser($script))
            ->parse()
            ->getValue();
    }
    
    /*
     * Links logic
     */
    
    /**
     * @return LinkWidgetParser[]
     */
    public function getHeaderLinks(): array
    {
        return $this->headerLinks;
    }
    
    /**
     * @param array|null $links
     * @return $this
     */
    public function setHeaderLinks(?array $links)
    {
        $this->headerLinks = [];
        if ($links) {
            $this->addHeaderLinks($links);
        }
        return $this;
    }
    
    /**
     * @param array $links
     * @return $this
     * @throws Exception
     */
    public function addHeaderLinks(array $links)
    {
        foreach ($links as $iScript) {
            $this->addHeaderLink($iScript);
        }
        return $this;
    }
    
    /**
     * @param mixed $link
     * @return $this
     * @throws Exception
     */
    public function addHeaderLink($link)
    {
        if ($link = $this->parseLink($link)) {
            $this->headerLinks[] = $link;
        }
        return $this;
    }
    
    /**
     * @param mixed $link
     * @return LinkWidget|null
     * @throws Exception
     */
    protected function parseLink($link): ?LinkWidget
    {
        return (new LinkWidgetParser($link))
            ->parse()
            ->getValue();
    }
}
