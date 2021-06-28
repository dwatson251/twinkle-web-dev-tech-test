<?php


namespace Twinkl\Core\Helper\ArrayExt;

use Twinkl\Core\Helper\BaseHelper;
use Twinkl\Core\Helper\EvalExt\EvalHelper;

/**
 * Class MapHelper
 * @package Twinkl\Core\Helper\ArrayExt
 * @method array getSource()
 */
class MapHelper extends BaseHelper implements IMapHelper
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
    public function setSource(?array $src)
    {
        return parent::setSource($src ?: []);
    }
    
    /*
     * Getter / Return logic
     */
    
    /**
     * @param array|null $keys
     * @return array
     */
    public function getAllAt(array $keys)
    {
        if (!$this->src) {
            return [];
        }
        return array_intersect_key(
            $this->src,
            array_fill_keys($keys, true)
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
    
    /*
     * Setter logic
     */
    
    /**
     * @param array $value
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
     * @param array $keys
     * @return $this
     */
    public function unsetAllAt(array $keys)
    {
        if (!$this->src) {
            return $this;
        }
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
     * @param array $keys
     * @return bool
     */
    public function issetAllAt(array $keys): bool
    {
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
     * @param array $keys
     * @return bool
     */
    public function existsAllAt(array $keys): bool
    {
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
     * @param array $keys
     * @return bool
     */
    public function isEmptyAllAt(array $keys): bool
    {
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
            array_keys($this->src),
            static function ($iItem) use (&$evalHelper) {
                return !$evalHelper
                    ->setSource($iItem)
                    ->isEmpty();
            }
        );
    }
    
    /**
     * @param array $keys
     * @return array
     */
    public function filterEmptyAllAt(array $keys)
    {
        $evalHelper = new EvalHelper();
        return array_filter(
            $keys,
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
     * @return array
     */
    public function filterEmptyKeys()
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
}
