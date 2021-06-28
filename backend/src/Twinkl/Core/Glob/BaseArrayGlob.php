<?php

namespace Twinkl\Core\Glob;

use Twinkl\Core\Helper\ArrayExt\ArrayHelper;
use Twinkl\Core\Helper\EvalExt\EvalHelper;
use Twinkl\Core\Util\EvalUtil;
use Twinkl\Core\Util\Util;

/**
 * Class BaseArrayGlob
 * @package Twinkl\Core\Glob
 */
abstract class BaseArrayGlob
{
    /*
     * Getter logic
     */
    
    /**
     * @return array
     */
    abstract public function getAll() : array;
    
    /**
     * @param array $keys
     * @return array
     */
    public function getAllAt(array $keys) : array
    {
        return array_intersect_key(
            $this->getAll(),
            $keys
        );
    }
    
    /**
     * @param mixed $key
     * @return mixed|null
     */
    public function get($key)
    {
        return $this->getAll()[$key] ?? null;
    }
    
    /**
     * Setter logic
     */
    
    /**
     * @param array|null $glob
     * @return $this
     */
    abstract public function setAll(?array $glob);
    
    /**
     * @param array $glob
     * @return $this
     */
    public function setAllAt(array $glob)
    {
        return $this->setAll(
            array_replace(
                $this->getAll(),
                $glob
            )
        );
    }
    
    /**
     * @param mixed $key
     * @param mixed $value
     * @return $this
     */
    public function set($key, $value)
    {
        return $this->setAllAt([$key => $value]);
    }
    
    /*
     * Puller logic
     */
    
    /**
     * @return array
     */
    public function pullAll() : array
    {
        $glob = $this->getAll();
        $this->setAll([]);
        return $glob;
    }
    
    /**
     * @param array $keys
     * @return array
     */
    public function pullAllAt(array $keys) : array
    {
        $return = $this->getAllAt($keys);
        $this->unsetAllAt($keys);
        return $return;
    }
    
    /**
     * @param mixed $key
     * @return mixed|null
     */
    public function pullAt($key)
    {
        $return = $this->pullAllAt([$key]);
        return array_pop($return);
    }
    
    /*
     * Unset logic
     */
    
    /**
     * @param mixed ...$keys
     * @return $this
     */
    public function unsetAllAt(...$keys)
    {
        return $this->setAll(
            (new ArrayHelper($this->getAll()))->unsetAllAt($keys)->getAllAt()
        );
    }
    
    /*
     * Isset logic
     */
    
    /**
     * @param mixed ...$keys
     * @return bool
     */
    public function issetAllAt(...$keys)
    {
        return (new EvalHelper($this->getAll()))->issetAllAt(...$keys);
    }
    
    /*
     * Exists logic
     */
    
    /**
     * @param mixed ...$keys
     * @return bool
     */
    public function existsAllAt(...$keys)
    {
        return (new EvalHelper($this->getAll()))->existsAllAt(...$keys);
    }
    
    /*
     * Empty logic
     */
    
    /**
     * @param mixed ...$keys
     * @return bool
     */
    public function isEmptyAllAt(...$keys)
    {
        return (new EvalHelper($this->getAll()))->isEmptyAllAt($keys);
    }
}
