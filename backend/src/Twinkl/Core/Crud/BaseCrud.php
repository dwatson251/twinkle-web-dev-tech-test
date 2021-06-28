<?php

namespace Twinkl\Core\Crud;

use Twinkl\Core\Glob\GlobalsGlob;

/**
 * Class BaseCrud
 * @package Twinkl\Core\Crud
 */
class BaseCrud
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
     * BaseCrud constructor.
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
     * Glob logic
     */
    
    /**
     * @return bool
     */
    protected function useSessAsDb(): bool
    {
        return (new GlobalsGlob())->getUseSessAsDb(true);
    }
}
