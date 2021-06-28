<?php

namespace Twinkl\Core\Widget\CustomTrait;

/**
 * Trait ContentWidgetTrait
 * @package Twinkl\Widget\Core\CustomTrait
 */
trait ContentWidgetTrait
{
    /*
     * Properties
     */
    
    /**
     * @var mixed|null
     */
    protected $content;
    
    /*
     * Magic method logic
     */
    
    public function __toString()
    {
        return $this->renderContent();
    }
    
    /*
     * Content logic
     */
    
    /**
     * @return mixed|null
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * @param mixed|null $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
    
    /**
     * @return string
     */
    public function renderContent(): string
    {
        return (string) $this->getContent();
    }
}
