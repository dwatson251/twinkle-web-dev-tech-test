<?php

namespace Twinkl\Core\Helper\ArrayExt;


use Exception;
use Twinkl\Core\Exception\ParseException;

/**
 * Class ArrayHelper
 * @package Twinkl\Core\Helper\ArrayExt
 * @method array getSource()
 */
interface IArrayHelper
{
    /**
     * @param array|null $src
     * @return $this
     */
    public function setSource($src);
    
    /**
     * @param array|null $keys
     * @param int|null $offset
     * @param int|null $len
     * @return array
     */
    public function getAllAt(?array $keys, int $offset = null, int $len = null);
    
    /**
     * @param mixed $key
     * @return mixed|null
     */
    public function getAt($key);
    
    /**
     * @param array|null $value
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
     * @param array $value
     * @return $this
     */
    public function addAll(array $value);
    
    /**
     * @param array $value
     * @return $this
     * @throws Exception|ParseException
     */
    public function addAllAt(array $value);
    
    /**
     * @param int|null $idx
     * @param mixed $value
     * @return $this
     */
    public function addAt(?int $idx, $value);
    
    /**
     * @param array|null $idxs
     * @param int|null $offset
     * @param int|null $len
     * @return $this
     */
    public function removeAllAt(?array $idxs, int $offset = null, int $len = null);
    
    /**
     * @param int|null $idx
     * @return $this
     */
    public function removeAt(?int $idx);
    
    /**
     * @return $this
     */
    public function unsetAll();
    
    /**
     * @param array|null $keys
     * @param int|null $offset
     * @param int|null $len
     * @return $this
     */
    public function unsetAllAt(?array $keys, int $offset = null, int $len = null);
    
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
     * @param array|null $keys
     * @param int|null $offset
     * @param int|null $len
     * @return bool
     */
    public function issetAllAt(?array $keys, int $offset = null, int $len = null): bool;
    
    /**
     * @param mixed $key
     * @return bool
     */
    public function issetAt($key): bool;
    
    /**
     * @param array|null $keys
     * @param int|null $offset
     * @param int|null $len
     * @return bool
     */
    public function existsAllAt(?array $keys, int $offset = null, int $len = null): bool;
    
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
     * @param array|null $keys
     * @param int|null $offset
     * @param int|null $len
     * @return bool
     */
    public function isEmptyAllAt(?array $keys, int $offset = null, int $len = null): bool;
    
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
     * @param array|null $keys
     * @param int|null $offset
     * @param int|null $len
     * @return array
     */
    public function filterEmptyAllAt(?array $keys, int $offset = null, int $len = null);
    
    /**
     * @param int|null $offset
     * @param int|null $len
     * @return array
     */
    public function sliceKeys(?int $offset, int $len = null): array;
    
    /**
     * @return array
     */
    public function filterEmptyKeys(): array;
    
    /**
     * @return mixed|null
     */
    public function first();
    
    /**
     * @return mixed|null
     */
    public function last();
}
