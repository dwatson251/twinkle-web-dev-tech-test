<?php


namespace Twinkl\Core\CustomTrait\Handler\Sanitise;

use Exception;
use Twinkl\Core\Exception\SanitiseException;
use Twinkl\Core\Helper\Sanitise\FilterVarArraySanitiseHelper;

/**
 * Trait ArraySanitiseHandlerTrait
 * @package Twinkl\Core\CustomTrait\Handler
 */
trait ArraySanitiseHandlerTrait
{
    /**
     * @return $this
     * @throws Exception|SanitiseException
     */
    public function sanitise()
    {
        $this
            ->returnSanitiseHelper()
            ->run();
        return $this->refreshSanitiseData();
    }
    
    /**
     * @param array $keys
     * @return $this
     * @throws Exception|SanitiseException
     */
    public function sanitiseAllAt(array $keys)
    {
        $this
            ->returnSanitiseHelper()
            ->sanitiseAllAt($keys);
        return $this->refreshSanitiseData();
    }
    
    /**
     * @param mixed $key
     * @return $this
     * @throws Exception|SanitiseException
     */
    public function sanitiseAt($key)
    {
        $this
            ->returnSanitiseHelper()
            ->sanitiseAt($key);
        return $this->refreshSanitiseData();
    }
    
    /**
     * @return FilterVarArraySanitiseHelper
     */
    abstract public function returnSanitiseHelper(): FilterVarArraySanitiseHelper;
    
    /**
     * @return $this
     */
    abstract public function refreshSanitiseData();
}
