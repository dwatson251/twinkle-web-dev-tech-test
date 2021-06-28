<?php

namespace Twinkl\Core\Parser;

use Twinkl\Core\Exception\ParseException;

/**
 * Class IParser
 * @package Twinkl\Core\Parser
 */
interface IParser
{
    /**
     * @return bool
     */
    public function issetValue(): bool;
    
    /**
     * @return mixed|null
     */
    public function returnValue();
    
    /**
     * @return mixed|null
     */
    public function getDefaultValue();
    
    /**
     * @return mixed|null
     */
    public function getContext();
    
    /**
     * @return array
     */
    public function getConfig(): array;
    
    /**
     * @param mixed|null $context
     * @return $this
     */
    public function setContext($context);
    
    /**
     * @param string|null $prop
     * @return $this
     */
    public function setProperty(?string $prop);
    
    /**
     * @param mixed|null $value
     * @return $this
     */
    public function setValue($value);
    
    /**
     * @return string|null
     */
    public function getProperty(): ?string;
    
    /**
     * @param array|null $config
     * @return $this
     */
    public function setConfig(?array $config);
    
    /**
     * @return mixed|null
     */
    public function getValue();
    
    /**
     * @param mixed|null $defValue
     * @return $this
     */
    public function setDefaultValue($defValue);
    
    /**
     * @return $this
     * @throws ParseException
     */
    public function parse();
}
