<?php

namespace Twinkl\Core\Helper\ClassExt;

use Exception;
use LogicException;
use ReflectionClass;
use ReflectionException;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Exception\ExceptionExt;
use Twinkl\Core\Exception\ParseException;
use Twinkl\Core\Helper\BaseHelper;

/**
 * Class ReflectionClassHelper
 * @package Twinkl\Core\Helper\ClassExt
 * @property string|null $src
 * @method string|null getSource()
 */
class ReflectionClassHelper extends BaseHelper
{
    /*
     * Properties
     */
    
    /**
     * @var ReflectionClass|null
     */
    protected $reflClass;
    /**
     * @var mixed|null
     */
    protected $inst;
    /**
     * @var mixed|null
     */
    protected $context;
    
    /*
     * Init logic
     */
    
    /**
     * ClassHelper constructor.
     * @param mixed|null $src
     * @param array|null $reflClassArgs
     * @param mixed|null $context
     * @param array|null $config
     */
    public function __construct(
        $src = null,
        array $reflClassArgs = null,
        $context = null,
        $config = null
    ) {
        parent::__construct($src, $config);
        $this
            ->setReflectionClassArgs($reflClassArgs)
            ->setContext($context);
    }
    
    /*
     * Source logic
     */
    
    public function setSource($src)
    {
        $this->src = $this->parseSource($src);
        return $this;
    }
    
    /**
     * @param mixed $src
     * @return string|null
     * @throws ParseException
     */
    protected function parseSource($src): ?string
    {
        try {
            if ($src === null) {
                return null;
            }
            if (is_string($src)) {
                if (!class_exists($src)) {
                    throw new LogicException(
                        "Class does not exist: {$src}.",
                        HttpConsts::CODE_SERVER_ERROR
                    );
                }
                return $src;
            }
            if (!($src = get_class($src))) {
                throw new LogicException(
                    'Source is not a class instance.',
                    HttpConsts::CODE_SERVER_ERROR
                );
            }
            return $src;
        } catch (Exception $ex) {
            throw new ParseException(
                'Invalid source.',
                HttpConsts::CODE_SERVER_ERROR,
                $ex->getMessage(),
                'null / string / class instance.',
                $src,
                'src',
                $this->context,
                $ex
            );
        }
    }
    
    /*
     * Instance logic
     */
    
    /**
     * @return mixed|null
     */
    public function getInstance()
    {
        return $this->inst;
    }
    
    /*
     * Context logic
     */
    
    /**
     * @return mixed|null
     */
    public function getContext()
    {
        return $this->context;
    }
    
    /**
     * @param mixed|null $context
     * @return $this
     */
    public function setContext($context)
    {
        $this->context = $context;
        return $this;
    }
    
    /*
     * Reflection class logic
     */
    
    /**
     * @return ReflectionClass|null
     */
    public function getReflectionClass()
    {
        return $this->reflClass;
    }
    
    /**
     * @param mixed|null $reflClass
     * @return $this
     * @throws Exception|ReflectionException
     */
    public function setReflectionClass($reflClass)
    {
        $this->reflClass = $this->parseReflectionClass($reflClass);
        return $this;
    }
    
    /**
     * @param mixed $reflClass
     * @return ReflectionClass|null
     * @throws Exception|ReflectionException
     */
    public function parseReflectionClass($reflClass): ?ReflectionClass
    {
        if ($reflClass !== null
            && !($reflClass instanceof ReflectionClass)
        ) {
            $reflClass = new ReflectionClass($reflClass);
        }
        return $reflClass;
    }
    
    /**
     * @param bool $triggerEx
     * @return bool
     * @throws Exception
     */
    protected function checkIssetReflectionClass(bool $triggerEx = true)
    {
        if (!$this->reflClass) {
            if ($triggerEx) {
                throw new LogicException(
                    'Reflection class is not defined.',
                    HttpConsts::CODE_SERVER_ERROR
                );
            }
        }
        return true;
    }
    
    /**
     * @param bool $triggerEx
     * @return bool
     * @throws Exception
     */
    protected function checkInstantiableReflectionClass(bool $triggerEx = true)
    {
        $this->checkIssetReflectionClass($triggerEx);
        if (!$this->reflClass->isInstantiable()) {
            if ($triggerEx) {
                throw new LogicException(
                    'Reflection class is not instantiable.',
                    HttpConsts::CODE_SERVER_ERROR
                );
            }
            return false;
        }
        return true;
    }
    
    /*
     * Config logic
     */
    
    /**
     * @return array|null
     */
    public function getReflectionClassArgs(): ?array
    {
        return $this->config['refl_class_args'] ?? null;
    }
    
    /**
     * @param array|null $reflClassArgs
     * @return $this
     */
    public function setReflectionClassArgs(?array $reflClassArgs)
    {
        $this->config['refl_class_args'] = $reflClassArgs;
        return $this;
    }
    
    /**
     * @return array
     */
    public function returnReflectionClassArgs(): array
    {
        return $this->getReflectionClassArgs() ?? [];
    }
    
    /*
     * Build logic
     */
    
    /**
     * @return $this
     * @throws Exception
     */
    public function build()
    {
        $class = $this->src;
        try {
            $reflClass = new ReflectionClass($class);
            $reflClassArgs = $this->returnReflectionClassArgs();
            
            if (!$reflClass->isInstantiable()) {
                throw new LogicException(
                    'Reflection class is not instantiable.',
                    HttpConsts::CODE_SERVER_ERROR
                );
            }
            $inst = $reflClass->newInstanceArgs($reflClassArgs);
            
            [$this->reflClass, $this->inst] = [$reflClass, $inst];
            return $this;
        } catch (Exception $ex) {
            throw new ExceptionExt(
                "Unable to build class instance: {$class}.",
                $ex->getCode(),
                $ex->getMessage(),
                null,
                $ex
            );
        }
    }
    
    /*
     * Reset logic
     */
    
    /**
     * @return $this
     */
    public function reset()
    {
        $this->reflClass = null;
        $this->inst = null;
        return $this;
    }
}
