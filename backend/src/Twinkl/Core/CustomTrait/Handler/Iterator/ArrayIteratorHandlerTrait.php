<?php

namespace Twinkl\Core\CustomTrait\Handler\Iterator;

/**
 * Trait ArrayIteratorHandlerTrait
 * @package Twinkl\Core\CustomTrait\Handler
 */
trait ArrayIteratorHandlerTrait
{
    /*
     * Properties logic
     */
    
    /**
     * @var int
     */
    protected $iteratorIdx = 0;
    /**
     * @var mixed
     */
    protected $iteratorKey;
    
    /*
     * Iterator logic
     */
    
    /**
     * Returns array used for the iterator.
     * @return array
     */
    abstract protected function getIteratorData(): array;
    
    public function current()
    {
        return $this->getIteratorData()[$this->iteratorKey] ?? null;
    }
    
    public function key()
    {
        return $this->iteratorKey;
    }
    
    public function next()
    {
        ++$this->iteratorIdx;
        $this->iteratorKey = $this->returnIteratorKey();
    }
    
    public function rewind()
    {
        $this->iteratorIdx = 0;
        $this->iteratorKey = $this->returnIteratorKey();
    }
    
    public function valid()
    {
        return array_key_exists(
            $this->iteratorIdx,
            array_keys($this->getIteratorData())
        );
    }
    
    /**
     * @return mixed|null
     */
    protected function returnIteratorKey()
    {
        return array_keys($this->getIteratorData())[$this->iteratorIdx] ?? null;
    }
}
