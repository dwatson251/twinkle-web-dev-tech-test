<?php

namespace Twinkl\Core\CustomTrait\Handler\Data;

use Exception;
use Twinkl\Core\Helper\EvalExt\EvalHelper;
use Twinkl\Core\Parser\Json\JsonEncodeParser;

/**
 * Trait DataAssocArrayHandlerTrait
 * @package Twinkl\Core\CustomTrait
 */
trait DataAssocArrayHandlerTrait
{
    /*
     * Properties
     */
    
    /**
     * @var array
     */
    protected $data = [];
    
    /*
     * Magic methods
     */
    
    public function __get($key)
    {
        return $this->get($key);
    }
    
    public function __set($key, $value)
    {
        $this->set($key, $value);
    }
    
    public function __unset($key)
    {
        $this->unsetAllAt($key);
    }
    
    public function __isset($key)
    {
        $this->issetAllAt($key);
    }
    
    /*
     * Init logic
     */
    
    /**
     * DataAssocArrayHandlerTrait constructor.
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        $this->setAll($data);
    }
    
    /*
     * Getter logic
     */
    
    /**
     * @return array
     */
    public function getDefaultAll(): array
    {
        return [];
    }
    
    /**
     * @param array $keys
     * @return array
     */
    public function getDefaultAllAt(array $keys): array
    {
        if (!$keys) {
            return [];
        }
        return array_intersect_key(
            $this->getDefaultAll(),
            array_fill_keys($keys, true)
        );
    }
    
    /**
     * @param mixed $key
     * @return mixed|null
     */
    public function getDefault($key)
    {
        return $this->getDefaultAll()[$key] ?? null;
    }
    
    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->data;
    }
    
    /**
     * @param array $keys
     * @return array
     */
    public function getAllAt(array $keys): array
    {
        return array_intersect_key(
            $this->data,
            array_filter($keys)
        );
    }
    
    /**
     * @param mixed $key
     * @return mixed|null
     */
    public function get($key)
    {
        return $this->data[$key] ?? null;
    }
    
    /*
     * Setter logic
     */
    
    /**
     * @param array|null $data
     * @return $this
     */
    public function setAll(?array $data)
    {
        $this->data = $data ?? $this->getDefaultAll();
        return $this;
    }
    
    /**
     * @param array $data
     * @return $this
     */
    public function setAllAt(array $data)
    {
        return $this->setAll(
            array_replace($this->data, $data)
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
     * Unset logic
     */
    
    /**
     * @param mixed ...$keys
     * @return $this
     */
    public function unsetAllAt(...$keys)
    {
        foreach ($keys as $iKey) {
            unset($this->src[$iKey]);
        }
        return $this;
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
        return (new EvalHelper($this->data))->issetAllAt(...$keys);
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
        return (new EvalHelper($this->data))->existsAllAt(...$keys);
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
        return (new EvalHelper($this->data))->isEmptyAllAt(...$keys);
    }
    
    /*
     * JSON logic
     */
    
    /**
     * @return string|null
     * @throws Exception
     */
    public function toJson()
    {
        return (new JsonEncodeParser($this->data))
            ->parse()
            ->getValue();
    }
    
    /*
     * Keys logic
     */
    
    /**
     * @return array
     */
    public function keysAll(): array
    {
        return array_keys($this->data);
    }
    
    /*
     * Reset logic
     */
    
    /**
     * @return $this
     */
    public function resetData()
    {
        $this->data = $this->getDefaultAll();
        return $this;
    }
    
    /*
     * Clear logic
     */
    
    /**
     * @return $this
     */
    public function clearData()
    {
        $this->data = [];
        return $this;
    }
    
    /*
     * Clean logic
     */
    
    /**
     * @return $this
     */
    public function cleanData()
    {
        $this->data = array_intersect_key(
            $this->data,
            $this->getDefaultAll()
        );
        return $this;
    }
}
