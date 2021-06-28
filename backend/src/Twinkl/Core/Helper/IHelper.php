<?php

namespace Twinkl\Core\Helper;

/**
 * Class BaseHelper
 * @package Twinkl\Core\Helper
 */
interface IHelper
{
    /**
     * @return mixed
     */
    public function getSource();
    
    /**
     * @param mixed $src
     * @return $this
     */
    public function setSource($src);
    
    /**
     * @return array
     */
    public function getConfig();
    
    /**
     * @param array|null $config
     * @return $this
     */
    public function setConfig(?array $config);
}
