<?php


namespace Twinkl\Core\Widget\CustomTrait;

/**
 * Trait ParentWidgetTrait
 * @package Twinkl\Widget\Core\CustomTrait
 */
trait ParentWidgetTrait
{
    /*
     * Properties
     */
    
    /**
     * @var array
     */
    protected $children = [];
    
    /*
     * Children logic
     */
    
    /**
     * @return array
     */
    public function getChildren(): array
    {
        return $this->children;
    }
    
    /**
     * @param array|null $children
     * @return $this
     */
    public function setChildren(?array $children)
    {
        $this->children = $children ?? [];
        return $this;
    }
}
