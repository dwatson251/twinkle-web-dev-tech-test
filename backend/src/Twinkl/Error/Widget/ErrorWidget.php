<?php

namespace Twinkl\Error\Widget;

use Exception;
use Twinkl\Core\Helper\Debug\VarDumpDebugHelper;

/**
 * Class ErrorWidget
 * @package Twinkl\Widget\Error
 */
class ErrorWidget extends BaseWidget
{
    /*
     * Properties
     */
    
    /**
     * @var Exception|null
     */
    protected $ex;
    
    /*
     * Error logic
     */
    
    /**
     * @return Exception|null
     */
    public function getException(): ?Exception
    {
        return $this->ex;
    }
    
    /**
     * @param Exception|null $ex
     * @return $this
     */
    public function setException(?Exception $ex)
    {
        $this->ex = $ex;
        return $this;
    }
    
    /*
     * Render logic
     */
    
    /**
     * @return string
     */
    public function render(): string
    {
        if (!$this->ex) {
            return '';
        }
        return (new VarDumpDebugHelper($this->ex))->dump();
    }
}
