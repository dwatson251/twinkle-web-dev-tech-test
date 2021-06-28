<?php

namespace Twinkl\Core\TemplateBuilder;

use Twinkl\Core\InterfaceExt\IRenderable;

/**
 * Class BaseTemplateBuilder
 * @package Twinkl\Core\TemplateBuilder
 */
abstract class BaseTemplateBuilder implements IRenderable
{
    /*
     * Properties logic
     */
    
    /**
     * @var string|null
     */
    protected $templateName;
    /**
     * @var array
     */
    protected $config = [];
    
    /*
     * Init logic
     */
    
    /**
     * BaseTemplateBuilder constructor.
     * @param string|null $templateName
     * @param array|null $config
     */
    public function __construct(string $templateName = null, array $config = null)
    {
        $this
            ->setTemplateName($templateName)
            ->setConfig($config);
    }
    
    /*
     * Template logic
     */
    
    /**
     * @return string|null
     */
    public function getTemplateName(): ?string
    {
        return $this->templateName;
    }
    
    /**
     * @param string|null $templateName
     * @return $this
     */
    public function setTemplateName(?string $templateName)
    {
        $this->templateName = $templateName;
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
    
    /*
     * Render logic
     */
    
    /**
     * @return string
     */
    abstract public function render();
}
