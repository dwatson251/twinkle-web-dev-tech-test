<?php


namespace Twinkl\Core\CustomTrait\Handler;

use Exception;
use Twinkl\Core\Helper\Debug\ClassDebugHelper;

/**
 * Trait DataAssocArraySerialiseHandlerTrait
 * @package Twinkl\Core\CustomTrait\Handler
 */
trait SerialiseHandlerTrait
{
    /**
     * @return string
     */
    public function serialize()
    {
        try {
            $serialised = (new ClassDebugHelper($this))->returnVars();
        } catch (Exception $ex) {
            $serialised = null;
        }
        return serialize($serialised);
    }
    
    public function unserialize($serialised): void
    {
        $unserialised = unserialize($serialised, ['allowed_classes' => true]);
        foreach ($unserialised as $iProp => $iVal) {
            $this->$iProp = $iVal;
        }
    }
    
    /**
     * @return array
     */
    protected function returnSerializeMap(): array
    {
        try {
            return (new ClassDebugHelper($this))->returnVars();
        } catch (Exception $ex) {
            return [];
        }
    }
}
