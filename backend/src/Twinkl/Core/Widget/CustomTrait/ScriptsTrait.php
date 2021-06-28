<?php


namespace Twinkl\Core\Widget\CustomTrait;

use Twinkl\Core\Widget\Script\ScriptWidget;

/**
 * Trait ScriptsTrait
 * @package Twinkl\Widget\Core\CustomTrait
 */
trait ScriptsTrait
{
    /*
     * Properties
     */
    
    /**
     * @var ScriptWidget[]
     */
    protected $scripts = [];
    
    /*
     * Scripts logic
     */
    
    /**
     * @return ScriptWidget[]
     */
    public function getScripts(): array
    {
        return $this->scripts;
    }
    
    /**
     * @param ScriptWidget[]|null $scripts
     * @return $this
     */
    public function setScripts(?array $scripts)
    {
        $this->scripts = $scripts ?? [];
        return $this;
    }
    
    /**
     * @return ScriptWidget[]
     */
    public function returnScripts(): array
    {
        return $this->scripts;
    }
}
