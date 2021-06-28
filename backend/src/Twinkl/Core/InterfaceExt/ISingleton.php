<?php


namespace Twinkl\Core\InterfaceExt;

/**
 * Interface ISingleton
 * @package Twinkl\Core\InterfaceExt
 */
interface ISingleton
{
    /**
     * @param mixed ...$args
     * @return static
     */
    public static function getInstance(...$args);
}
