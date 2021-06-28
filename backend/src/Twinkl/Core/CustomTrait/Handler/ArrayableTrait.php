<?php


namespace Twinkl\Core\CustomTrait\Handler;

use Exception;
use Twinkl\Core\Helper\Debug\ClassDebugHelper;

/**
 * Class ArrayableTrait
 * @package Twinkl\Core\CustomTrait\Handler
 */
trait ArrayableTrait
{
    /**
     * @return array
     */
    public function toArray()
    {
        try {
            return (new ClassDebugHelper($this))->returnVars();
        } catch (Exception $ex) {
            return [];
        }
    }
}