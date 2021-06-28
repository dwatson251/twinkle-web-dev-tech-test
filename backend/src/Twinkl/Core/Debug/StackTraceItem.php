<?php


namespace Twinkl\Core\Debug;

use Exception;
use ReflectionException;
use Twinkl\Core\Helper\Debug\ClassDebugHelper;

/**
 * Class StackTraceItem
 * @package Twinkl\Core\Debug
 * @see https://www.php.net/manual/en/function.debug-backtrace.php
 */
class StackTraceItem
{
    /*
     * Properties
     */
    
    /**
     * @var string|null
     */
    protected $function;
    /**
     * @var int|null
     */
    protected $line;
    /**
     * @var string|null
     */
    protected $file;
    /**
     * @var string|null
     */
    protected $class;
    /**
     * @var mixed|null
     */
    protected $obj;
    /**
     * @var string|null
     */
    protected $type;
    /**
     * @var array
     */
    protected $args = [];
    
    /*
     * Init logic
     */
    
    /**
     * StackTrace constructor.
     * @param string|null $function
     * @param array|null $args
     * @param mixed|null $obj
     * @param string|null $class
     * @param string|null $file
     * @param int|null $line
     * @param string|null $type
     * @throws Exception
     */
    public function __construct(
        string $function = null,
        array $args = null,
        $obj = null,
        string $class = null,
        string $file = null,
        int $line = null,
        string $type = null
    ) {
        $this
            ->setFunction($function)
            ->setArgs($args)
            ->setObject($obj)
            ->setClass($class)
            ->setFile($file)
            ->setLine($line)
            ->setType($type);
    }
    
    /*
     * Function logic
     */
    
    /**
     * @return string|null
     */
    public function getFunction()
    {
        return $this->function;
    }
    
    /**
     * @param string|null $func
     * @return $this
     */
    public function setFunction(?string $func)
    {
        $this->function = $func;
        return $this;
    }
    
    /*
     * Line logic
     */
    
    /**
     * @return int|null
     */
    public function getLine()
    {
        return $this->line;
    }
    
    /**
     * @param int|null $line
     * @return $this
     */
    public function setLine(?int $line)
    {
        $this->line = $line;
        return $this;
    }
    
    /*
     * File logic
     */
    
    /**
     * @return string|null
     */
    public function getFile()
    {
        return $this->line;
    }
    
    /**
     * @param string|null $file
     * @return $this
     */
    public function setFile(?string $file)
    {
        $this->file = $file;
        return $this;
    }
    
    /*
     * Class logic
     */
    
    /**
     * @return string|null
     */
    public function getClass()
    {
        return $this->class;
    }
    
    /**
     * @param string|null $class
     * @return $this
     * @throws Exception
     */
    public function setClass(?string $class)
    {
        $this->class = $class;
        return $this;
    }
    
    /*
     * Object logic
     */
    
    /**
     * @return mixed|null
     */
    public function getObject()
    {
        return $this->obj;
    }
    
    /**
     * @param mixed|null $obj
     * @return $this
     */
    public function setObject($obj)
    {
        $this->obj = $obj;
        return $this;
    }
    
    /*
     * Type logic
     */
    
    /**
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * @param string|null $type
     * @return $this
     */
    public function setType(?string $type)
    {
        $this->type = $type;
        return $this;
    }
    
    /*
     * Args logic
     */
    
    /**
     * @return array
     */
    public function getArgs()
    {
        return $this->args;
    }
    
    /**
     * @param array|null $args
     * @return $this
     */
    public function setArgs(?array $args)
    {
        $this->args = $args ?? [];
        return $this;
    }
    
    /*
     * Array logic
     */
    
    /**
     * @return array
     */
    public function toArray()
    {
        try {
            return (new ClassDebugHelper($this))->returnVars();
        } catch (Exception $ex) {
            return [];
        }
    }
}
