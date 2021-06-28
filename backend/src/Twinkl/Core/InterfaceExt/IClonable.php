<?php

namespace Twinkl\Core\InterfaceExt;

/**
 * Interface IClonable
 * @package Twinkl\Core\InterfaceExt
 */
interface IClonable
{
    /**
     * @return mixed
     */
    public function __clone();
}
