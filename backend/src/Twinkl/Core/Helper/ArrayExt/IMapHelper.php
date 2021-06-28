<?php

namespace Twinkl\Core\Helper\ArrayExt;


use Twinkl\Core\Helper\IHelper;

/**
 * Class MapHelper
 * @package Twinkl\Core\Helper\ArrayExt
 * @method array getSource()
 */
interface IMapHelper extends IHelper
{
    /**
     * @param array|null $src
     * @return $this
     */
    public function setSource($src);
    
    /**
     * @param array|null $keys
     * @return array
     */
    public function getAllAt(array $keys);
    
    /**
     * @param mixed $key
     * @return mixed|null
     */
    public function getAt($key);
    
    /**
     * @param array $value
     * @return $this
     */
    public function setAllAt(array $value);
    
    /**
     * @param mixed $key
     * @param mixed $value
     * @return $this
     */
    public function setAt($key, $value);
    
    /**
     * @return $this
     */
    public function unsetAll();
    
    /**
     * @param array $keys
     * @return $this
     */
    public function unsetAllAt(array $keys);
    
    /**
     * @param mixed $key
     * @return $this
     */
    public function unsetAt($key);
    
    /**
     * @return $this
     */
    public function unsetEmptyKeys();
    
    /**
     * @return bool
     */
    public function issetAll(): bool;
    
    /**
     * @param array $keys
     * @return bool
     */
    public function issetAllAt(array $keys): bool;
    
    /**
     * @param mixed $key
     * @return bool
     */
    public function issetAt($key): bool;
    
    /**
     * @param array $keys
     * @return bool
     */
    public function existsAllAt(array $keys): bool;
    
    /**
     * @param mixed $key
     * @return bool
     */
    public function existsAt($key): bool;
    
    /**
     * @return bool
     */
    public function isEmptyAll(): bool;
    
    /**
     * @param array $keys
     * @return bool
     */
    public function isEmptyAllAt(array $keys): bool;
    
    /**
     * @param mixed $key
     * @return bool
     */
    public function isEmptyAt($key): bool;
    
    /**
     * @return array
     */
    public function filterEmptyAll();
    
    /**
     * @param array $keys
     * @return array
     */
    public function filterEmptyAllAt(array $keys);
    
    /**
     * @return array
     */
    public function filterEmptyKeys();
}