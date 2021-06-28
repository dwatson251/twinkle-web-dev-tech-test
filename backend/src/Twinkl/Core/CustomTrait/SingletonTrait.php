<?php

namespace Twinkl\Core\CustomTrait;

/**
 * Trait SingletonTrait
 * @package Twinkl\Core\CustomTrait
 */
trait SingletonTrait
{
    /**
     * @var static|null
     */
    protected static $instance;
    
    /**
     * @param mixed ...$args
     * @return static
     */
    public static function getInstance(...$args)
    {
        if (!isset(static::$instance)) {
            static::$instance = new static(...$args);
        }
        return static::$instance;
    }
}
