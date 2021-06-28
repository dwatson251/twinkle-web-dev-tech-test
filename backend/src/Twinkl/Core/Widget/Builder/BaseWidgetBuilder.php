<?php


namespace Twinkl\Core\Widget\Builder;


use Twinkl\Core\InterfaceExt\IBuildable;

/**
 * Class BaseWidgetBuilder
 * @package Twinkl\Core\Widget\Builder
 */
abstract class BaseWidgetBuilder implements IBuildable
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
     * BaseWidgetBuilder constructor.
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
     * @param array $config
     * @return $this
     */
    public function setConfig(?array $config)
    {
        $this->config = $config ?? [];
        return $this;
    }
    
    
    /*
     * Build logic
     */
    
    /**
     * @return $this
     */
    abstract public function build();
}
