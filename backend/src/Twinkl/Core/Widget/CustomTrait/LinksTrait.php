<?php


namespace Twinkl\Core\Widget\CustomTrait;

use Twinkl\Core\Widget\Link\LinkWidget;

/**
 * Trait LinksTrait
 * @package Twinkl\Widget\Core\CustomTrait
 */
trait LinksTrait
{
    /*
     * Properties
     */
    
    /**
     * @var LinkWidget[]
     */
    protected $links = [];
    
    /*
     * Links logic
     */
    
    /**
     * @return LinkWidget[]
     */
    public function getLinks(): array
    {
        return $this->links;
    }
    
    /**
     * @param LinkWidget[]|null $links
     * @return $this
     */
    public function setLinks(?array $links)
    {
        $this->links = $links ?? [];
        return $this;
    }
    
    /**
     * @return LinkWidget[]
     */
    public function returnLinks(): array
    {
        return $this->links;
    }
}
