<?php

namespace Twinkl\Core\Helper\CloneExt;

use Twinkl\Core\Helper\BaseHelper;
use Twinkl\Core\InterfaceExt\IClonable;

/**
 * Class DeepCloneHelper
 * @package Twinkl\Core\Helper\CloneExt
 */
class CloneHelper extends BaseHelper
{
    /*
     * Properties
     */
    
    /**
     * @var mixed|null
     */
    protected $clone;
    
    /**
     * @var null|int
     */
    protected $maxLvl;
    
    /*
     * Init logic
     */
    
    /**
     * CloneHelper constructor.
     * @param null $src
     * @param int|null $maxLvl
     * @param array|null $config
     */
    public function __construct($src = null, int $maxLvl = null, array $config = null)
    {
        parent::__construct($src, $config);
        $this->setMaxLevel($maxLvl);
    }
    
    /*
     * Depth logic
     */
    
    /**
     * @return int|null
     */
    public function getMaxLevel()
    {
        return $this->maxLvl;
    }
    
    /**
     * @param int|null $maxLvl
     * @return $this
     */
    public function setMaxLevel(?int $maxLvl)
    {
        $this->maxLvl = $maxLvl;
        return $this;
    }
    
    /*
     * Clone logic
     */
    
    /**
     * @return mixed|null
     */
    public function getClone()
    {
        return $this->clone;
    }
    
    /**
     * @return $this
     */
    public function clone()
    {
        if ($this->checkEmptySource()) {
            return $this;
        }
        $this->clone = $this->shallowClone($this->src);
        return $this;
    }
    
    /**
     * @param mixed $item
     * @return mixed
     */
    protected function shallowClone($item)
    {
        return $this->canCloneItem($this->src) ?
            clone $item
            : $item;
    }
    
    /**
     * @return $this
     */
    public function cloneDeep()
    {
        if ($this->checkEmptySource()) {
            return $this;
        }
        $this->clone = $this->recurseClone($this->src);
        return $this;
    }
    
    /**
     * @param array|object $item
     * @return array|object
     */
    protected function recurseClone($item, ?int $lvl = null)
    {
        [$lvl, $isObj,] = [$lvl ?? 0, is_object($item),];
        
        if (!$item
            || !$this->canCloneAtLevel($lvl)
        ) {
            return $item;
        }
        
        if ($this->canCloneItem($item)) {
            $item = clone $item;
        }
        
        if (!$this->canRecurseCloneItem($item, $lvl)) {
            return $item;
        }
        
        $nxtLvl = $lvl + 1;
        foreach ($item as $iKey => $iVal) {
            $iVal = $this->recurseClone($iVal, $nxtLvl);
            
            if (!$isObj) {
                $item->$iKey = $iVal;
                continue;
            }
            $item[$iKey] = $iVal;
        }
        
        return $item;
    }
    
    /**
     * @param int|null $lvl
     * @return bool
     */
    protected function canCloneAtLevel(?int $lvl)
    {
        [$lvl, $maxDepth,] = [$lvl ?? 0, $this->maxLvl ?? 0,];
        return (
            $maxDepth === 0
            || $lvl <= $maxDepth
        );
    }
    
    /**
     * @param mixed $item
     * @param int|null $lvl
     * @return bool
     */
    protected function canRecurseCloneItem($item, ?int $lvl)
    {
        return (
            is_iterable($item)
            && ($lvl ?? 0) < ($this->maxLvl ?? 0)
        );
    }
    
    /**
     * @param mixed $item
     * @return bool
     */
    protected function canCloneItem($item)
    {
        return (
            $item
            && $item instanceof IClonable
        );
    }
}
