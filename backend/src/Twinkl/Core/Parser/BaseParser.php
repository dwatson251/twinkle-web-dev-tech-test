<?php

namespace Twinkl\Core\Parser;

use Twinkl\Core\InterfaceExt\IParsable;
use Twinkl\Core\Exception\ParseException;
use Twinkl\Core\InterfaceExt\IResetable;

/**
 * Class BaseParser
 * @package Twinkl\Core\Helper\Parse
 */
abstract class BaseParser implements IParser, IParsable, IResetable
{
    /*
     * Properties
     */
    
    /**
     * @var mixed|null
     */
    protected $value;
    /**
     * @var mixed|null
     */
    protected $defValue;
    /**
     * @var null|string
     */
    protected $prop;
    /**
     * @var mixed|null
     */
    protected $context;
    /**
     * @var array
     */
    protected $config = [];
    /**
     * @var ParseException
     */
    protected $ex;
    
    /*
     * Init logic
     */
    
    /**
     * BaseParseHelper constructor.
     * @param mixed|null $value
     * @param mixed|null $defValue
     * @param string|null $prop
     * @param mixed|null $context
     * @param array|null $config
     */
    public function __construct(
        $value = null,
        $defValue = null,
        string $prop = null,
        $context = null,
        array $config = null
    ) {
        $this
            ->setValue($value)
            ->setDefaultValue($defValue)
            ->setProperty($prop)
            ->setContext($context)
            ->setConfig($config);
    }
    
    /*
     * Value logic
     */
    
    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * @param mixed|null $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
    
    /**
     * @return bool
     */
    public function issetValue(): bool
    {
        return $this->value !== null;
    }
    
    /**
     * @return mixed|null
     */
    public function returnValue()
    {
        return $this->value ?? $this->defValue;
    }
    
    /*
     * Default value logic
     */
    
    /**
     * @return mixed|null
     */
    public function getDefaultValue()
    {
        return $this->defValue;
    }
    
    /**
     * @param mixed|null $defValue
     * @return $this
     */
    public function setDefaultValue($defValue)
    {
        $this->defValue = $defValue;
        return $this;
    }
    
    /*
     * Property name logic
     */
    
    /**
     * @return string|null
     */
    public function getProperty(): ?string
    {
        return $this->prop;
    }
    
    /**
     * @param string|null $prop
     * @return $this
     */
    public function setProperty(?string $prop)
    {
        $this->prop = $prop;
        return $this;
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
     * Config logic
     */
    
    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }
    
    /**
     * @param array|null $config
     * @return $this
     */
    public function setConfig(?array $config)
    {
        $this->config = $config ?? [];
        return $this;
    }
    
    /*
     * Parse logic
     */
    
    /**
     * @return $this
     * @throws ParseException
     */
    abstract public function parse();
    
    /*
     * Error logic
     */
    
    /**
     * @return ParseException|null
     */
    public function getError(): ?ParseException
    {
        return $this->ex;
    }
    
    /**
     * @return bool
     */
    public function hasError(): bool
    {
        return $this->ex !== null;
    }
    
    /*
     * Reset logic
     */
    
    /**
     * @return $this
     */
    public function reset()
    {
        $this->ex = null;
        return $this;
    }
}
