<?php

namespace Twinkl\Core\InterfaceExt;

use Exception;

/**
 * Class IDataHandler
 * @package Twinkl\Core\InterfaceExt
 */
interface IDataHandler
{
    /**
     * @return array
     */
    public function getDefaultAll(): array;
    
    /**
     * @param array $keys
     * @return array
     */
    public function getDefaultAllAt(array $keys): array;
    
    /**
     * @param mixed $key
     * @return mixed|null
     */
    public function getDefault($key);
    
    /**
     * @return array
     */
    public function getAll(): array;
    
    /**
     * @param array $keys
     * @return array
     */
    public function getAllAt(array $keys): array;
    
    /**
     * @param mixed $key
     * @return mixed|null
     */
    public function get($key);
    
    /**
     * @param array|null $data
     * @return $this
     */
    public function setAll(?array $data);
    
    /**
     * @param array $data
     * @return $this
     */
    public function setAllAt(array $data);
    
    /**
     * @param mixed $key
     * @param mixed $value
     * @return $this
     */
    public function set($key, $value);
    
    /**
     * @param mixed ...$keys
     * @return $this
     */
    public function unsetAllAt(...$keys);
    
    /**
     * @param mixed ...$keys
     * @return bool
     */
    public function issetAllAt(...$keys);
    
    /**
     * @param mixed ...$keys
     * @return bool
     */
    public function existsAllAt(...$keys);
    
    /**
     * @param mixed ...$keys
     * @return bool
     */
    public function isEmptyAllAt(...$keys);
    
    /**
     * @return array
     */
    public function keysAll(): array;
}
