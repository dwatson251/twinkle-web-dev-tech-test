<?php


namespace Twinkl\Core\Helper;

/**
 * Class BaseHelper
 * @package Twinkl\Core\Helper
 */
abstract class BaseHelper implements IHelper
{
    /*
     * Properties
     */
    
    /**
     * @var mixed
     */
    protected $src;
    /**
     * @var array
     */
    protected $config = [];
    
    /*
     * Init logic
     */
    
    /**
     * BaseHelper constructor.
     * @param mixed|null $src
     * @param array|null $config
     */
    public function __construct($src = null, array $config = null)
    {
        $this
            ->setSource($src)
            ->setConfig($config);
    }
    
    /*
     * Source logic
     */
    
    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->src;
    }
    
    /**
     * @param mixed $src
     * @return $this
     */
    public function setSource($src)
    {
        $this->src = $src;
        return $this;
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
}
