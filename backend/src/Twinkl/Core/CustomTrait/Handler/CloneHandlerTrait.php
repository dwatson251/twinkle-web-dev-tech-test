<?php


namespace Twinkl\Core\CustomTrait\Handler;

use Exception;
use Twinkl\Core\Helper\CloneExt\CloneHelper;
use Twinkl\Core\Helper\Debug\ClassDebugHelper;

/**
 * Trait DataAssocArrayCloneHandlerTrait
 * @package Twinkl\Core\CustomTrait\Handler
 */
trait CloneHandlerTrait
{
    /**
     * @throws Exception
     */
    public function __clone()
    {
        $classVars = (new ClassDebugHelper($this))
            ->buildRelectionClass()
            ->returnVars();
        $cloneData = (new CloneHelper($classVars))->run();
        
        foreach ($cloneData as $iProp => $iVal) {
            $this->$iProp = $iVal;
        }
    }
}
