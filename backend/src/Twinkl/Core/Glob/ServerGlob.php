<?php

namespace Twinkl\Core\Glob;

use Twinkl\Core\Consts\LoggerConsts;
use Twinkl\Core\Consts\ServerConsts;

/**
 * Class ServerGlob
 * @package Twinkl\Core\Glob
 */
class ServerGlob extends BaseArrayGlob
{
    /*
     * Getter logic
     */
    
    /**
     * @return array
     */
    public function getAll(): array
    {
        return $_SERVER;
    }
    
    /**
     * Setter logic
     */
    
    public function setAll(?array $sess)
    {
        $_SERVER = $sess ?? [];
        return $this;
    }
    
    /*
     * Request logic
     */
    
    /**
     * @return string|null
     */
    public function getHttpXRequestedWith()
    {
        return $this->get(ServerConsts::NAME_HTTP_X_REQ_WITH);
    }
    
    /**
     * @return bool
     */
    public function isAjaxRequest() : bool
    {
        return $this->getHttpXRequestedWith() === ServerConsts::VAL_HTTP_X_REQ_WITH_AJAX;
    }
}
