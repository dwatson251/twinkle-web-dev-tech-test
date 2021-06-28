<?php

namespace Twinkl\Core\Handler;

use Twinkl\Core\InterfaceExt\IRunnable;

/**
 * Class BaseHandler
 * @package Twinkl\Core\Handler
 */
abstract class BaseHandler implements IRunnable
{
    /*
     * Properties
     */
    
    /**
     * @var array
     */
    protected $config = [];
    
    /*
     * Init logic
     */
    
    /**
     * BaseHandler constructor.
     * @param array|null $config
     */
    public function __construct(array $config = null)
    {
        $this->setConfig($config);
    }
    
    /*
     * Config logic
     */
    
    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }
    
    /**
     * @param array|null $config
     * @return $this
     */
    public function setConfig(?array $config)
    {
        $this->config = $config ?? [];
        return $this;
    }
    
    /*
     * Trigger exit logic
     */
    
    /**
     * @param bool $asBool
     * @return bool|null
     */
    public function getTriggerExit(bool $asBool = false): ?bool
    {
        $triggerExit = $this->config['trigger_exit'] ?? null;
        return $asBool ? $triggerExit === true : $triggerExit;
    }
    
    /**
     * @param bool|null $triggerExit
     * @return $this
     */
    public function setTriggerExit(?bool $triggerExit)
    {
        $this->config['trigger_exit'] = $triggerExit;
        return $this;
    }
    
    /*
     * Run logic
     */
    
    /**
     * @return $this
     */
    abstract public function run();
}
