<?php

namespace Twinkl\Core\Helper\ArrayExt;

use Countable;
use Exception;
use Twinkl\Core\Exception\ParseException;
use Twinkl\Core\Helper\BaseHelper;
use Twinkl\Core\Helper\EvalExt\EvalHelper;

/**
 * Class ArrayHelper
 * @package Twinkl\Core\Helper\ArrayExt
 * @method __construct(array $src = null)
 * @method array getSource()
 */
class ArrayHelper extends BaseHelper implements
    IArrayHelper,
    IMapHelper,
    Countable
{
    /*
     * Properties
     */
    
    /**
     * @var array
     */
    protected $src = [];
    
    /*
     * Source logic
     */
    
    /**
     * @param array|null $src
     * @return $this
     */
    public function setSource($src)
    {
        return parent::setSource($src ?: []);
    }
    
    /*
     * Getter / Return logic
     */
    
    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->src ?: [];
    }
    
    /**
     * @param array|null $keys
     * @param int|null $offset
     * @param int|null $len
     * @return array
     */
    public function getAllAt(?array $keys, int $offset = null, int $len = null)
    {
        if (!$this->src) {
            return [];
        }
        $keys = $this->returnMergeSliceKeys($keys, $offset, $len);
        return array_intersect_key(
            $this->src,
            array_unique(
                array_flip($keys)
            )
        );
    }
    
    /**
     * @param mixed $key
     * @return mixed|null
     */
    public function getAt($key)
    {
        return $this->src[$key] ?? null;
    }
    
    /**
     * @return mixed|null
     */
    public function first()
    {
        $src = $this->src;
        return array_unshift($src);
    }
    
    /**
     * @return mixed|null
     */
    public function last()
    {
        $src = $this->src;
        return array_pop($src);
    }
    
    /*
     * Setter logic
     */
    
    /**
     * @param array|null $value
     * @return $this
     */
    public function setAll(array $value)
    {
        $this->src = $value;
        return $this;
    }
    
    /**
     * @param array|null $value
     * @return $this
     */
    public function setAllAt(array $value)
    {
        if (!$value) {
            return $this;
        }
        $this->src = array_replace($this->src, $value);
        return $this;
    }
    
    /**
     * @param mixed $key
     * @param mixed $value
     * @return $this
     */
    public function setAt($key, $value)
    {
        return $this->setAllAt([$key => $value]);
    }
    
    /*
     * Adder logic
     */
    
    /**
     * @param array $value
     * @return $this
     */
    public function addAll(array $value)
    {
        if (!$value) {
            return $this;
        }
        $this->src = array_merge(
            $this->src,
            array_values($value)
        );
        return $this;
    }
    
    /**
     * @param array $value
     * @return $this
     * @throws Exception|ParseException
     */
    public function addAllAt(array $value)
    {
        if (!$value) {
            return $this;
        }
        $src = $this->src;
        foreach ($value as $iIdx => $iVal) {
            if (!is_int($iIdx)) {
                continue;
            }
            array_splice($src, $iIdx, $iVal);
        }
        $this->src = $src;
        return $this;
    }
    
    /**
     * @param int|null $idx
     * @param mixed $value
     * @return $this
     */
    public function addAt(?int $idx, $value)
    {
        if ($idx === null) {
            $this->src[] = $value;
            return $this;
        }
        array_slice($this->src, $idx, 0);
        return $this;
    }
    
    /*
     * Remove logic
     */
    
    /**
     * @param array|null $idxs
     * @param int|null $offset
     * @param int|null $len
     * @return $this
     */
    public function removeAllAt(?array $idxs, int $offset = null, int $len = null)
    {
        if (!$this->src) {
            return$this;
        }
        $idxs = $this->returnMergeSliceKeys($idxs, $offset, $len);
        
        foreach ($idxs as $iIdx) {
            if (!is_int($iIdx)) {
                continue;
            }
            array_splice($this->src, $iIdx, 1);
        }
        return $this;
    }
    
    /**
     * @param int|null $idx
     * @return $this
     */
    public function removeAt(?int $idx)
    {
        return $this->removeAllAt([$idx]);
    }
    
    /*
     * Unset logic
     */
    
    /**
     * @return $this
     */
    public function unsetAll()
    {
        $this->src = [];
        return $this;
    }
    
    /**
     * @param array|null $keys
     * @param int|null $offset
     * @param int|null $len
     * @return $this
     */
    public function unsetAllAt(?array $keys, int $offset = null, int $len = null)
    {
        if (!$this->src) {
            return$this;
        }
        $keys = $this->returnMergeSliceKeys($keys, $offset, $len);
        foreach ($keys as $iKey) {
            unset($this->src[$iKey]);
        }
        return $this;
    }
    
    /**
     * @param mixed $key
     * @return $this
     */
    public function unsetAt($key)
    {
        return $this->unsetAllAt([$key]);
    }
    
    /**
     * @return $this
     */
    public function unsetEmptyKeys()
    {
        $this->src = array_intersect_key(
            $this->src,
            $this->filterEmptyKeys()
        );
        return $this;
    }
    
    /*
     * Isset logic
     */
    
    /**
     * @return bool
     */
    public function issetAll(): bool
    {
        return (new EvalHelper($this->src))->issetAll();
    }
    
    /**
     * @param array|null $keys
     * @param int|null $offset
     * @param int|null $len
     * @return bool
     */
    public function issetAllAt(?array $keys, int $offset = null, int $len = null): bool
    {
        $keys = $this->returnMergeSliceKeys($keys, $offset, $len);
        return (new EvalHelper($this->src))->issetAllAt(...$keys);
    }
    
    /**
     * @param mixed $key
     * @return bool
     */
    public function issetAt($key): bool
    {
        return $this->issetAllAt([$key]);
    }
    
    /*
     * Exists logic
     */
    
    /**
     * @param array|null $keys
     * @param int|null $offset
     * @param int|null $len
     * @return bool
     */
    public function existsAllAt(?array $keys, int $offset = null, int $len = null): bool
    {
        $keys = $this->returnMergeSliceKeys($keys, $offset, $len);
        return (new EvalHelper($this->src))->existsAllAt(...$keys);
    }
    
    /**
     * @param mixed $key
     * @return bool
     */
    public function existsAt($key): bool
    {
        return $this->existsAllAt([$key]);
    }
    
    /*
     * Empty logic
     */
    
    /**
     * @return bool
     */
    public function isEmptyAll(): bool
    {
        return (new EvalHelper($this->src))->isEmptyAll();
    }
    
    /**
     * @param array|null $keys
     * @param int|null $offset
     * @param int|null $len
     * @return bool
     */
    public function isEmptyAllAt(?array $keys, int $offset = null, int $len = null): bool
    {
        $keys = $this->returnMergeSliceKeys($keys, $offset, $len);
        return (new EvalHelper($this->src))->isEmptyAllAt(...$keys);
    }
    
    /**
     * @param mixed $key
     * @return bool
     */
    public function isEmptyAt($key): bool
    {
        return $this->isEmptyAllAt([$key]);
    }
    
    /*
     * Filter logic
     */
    
    /**
     * @return array
     */
    public function filterEmptyAll()
    {
        $evalHelper = new EvalHelper();
        return array_filter(
            $this->src,
            static function ($iItem) use (&$evalHelper) {
                return !$evalHelper
                    ->setSource($iItem)
                    ->isEmpty();
            }
        );
    }
    
    /**
     * @param array|null $keys
     * @param int|null $offset
     * @param int|null $len
     * @return array
     */
    public function filterEmptyAllAt(?array $keys, int $offset = null, int $len = null)
    {
        $evalHelper = new EvalHelper();
        return array_filter(
            $this->getAllAt($keys, $offset, $len),
            static function ($iItem) use (&$evalHelper) {
                return !$evalHelper
                    ->setSource($iItem)
                    ->isEmpty();
            }
        );
    }
    
    /*
     * Keys logic
     */
    
    /**
     * @param int|null $offset
     * @param int|null $len
     * @return array
     */
    public function sliceKeys(?int $offset, int $len = null): array
    {
        if (!$this->src) {
            return [];
        }
        return array_slice(
            array_keys($this->src),
            $offset,
            $len
        );
    }
    
    /**
     * @return array
     */
    public function filterEmptyKeys(): array
    {
        $evalHelper = new EvalHelper();
        return array_filter(
            array_keys($this->src),
            static function ($iItem) use (&$evalHelper) {
                return !$evalHelper
                    ->setSource($iItem)
                    ->isEmptyStr();
            }
        );
    }
    
    /**
     * @param array|null $keys
     * @param int|null $offset
     * @param int|null $len
     * @return array
     */
    protected function returnMergeSliceKeys(?array $keys, int $offset = null, int $len = null): array
    {
        $keys = $keys ?? [];
        if ($offset !== null
            || $len !== null
        ) {
            $keys = array_merge(
                $keys,
                $this->sliceKeys($offset, $len)
            );
        }
        return $keys;
    }
    
    /*
     * Slice logic
     */
    
    /**
     * @param int $offset
     * @param int|null $len
     * @return array
     */
    public function slice(int $offset, int $len = null): array
    {
        return array_slice($this->src ?? [], $offset, $len);
    }
    
    /*
     * Count logic
     */
    
    
    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->src ?? []);
    }
}
