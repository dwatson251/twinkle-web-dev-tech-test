<?php


namespace Twinkl\Core\Consts;

/**
 * Class BoolConsts
 * @package Twinkl\Core\Consts
 */
class BoolConsts
{
    /*
     * Truthy logic
     */
    
    public const VAL_TRUE = 'true';
    public const VAL_TRUTHY = 'truthy';
    public const VAL_T = 't';
    public const VAL_YES = 'yes';
    public const VAL_Y = 'y';
    public const VAL_INT_T = 1;
    public const VAL_INT_STR_T = '1';
    public const VAL_ON = 'on';
    
    public const TRUTHY_ARR = [
        true,
        self::VAL_TRUE,
        self::VAL_TRUTHY,
        self::VAL_T,
        self::VAL_YES,
        self::VAL_Y,
        self::VAL_INT_T,
        self::VAL_INT_STR_T,
        self::VAL_ON,
    ];
    
    /*
     * Falsy logic
     */
    
    public const VAL_FALSE = 'false';
    public const VAL_FALSY = 'falsy';
    public const VAL_F = 'f';
    public const VAL_NO = 'no';
    public const VAL_N = 'n';
    public const VAL_INT_F = 0;
    public const VAL_INT_STR_F = '0';
    public const VAL_OFF = 'off';
    
    public const FALSY_ARR = [
        false,
        self::VAL_FALSE,
        self::VAL_FALSY,
        self::VAL_F,
        self::VAL_NO,
        self::VAL_N,
        self::VAL_INT_F,
        self::VAL_INT_STR_F,
        self::VAL_OFF,
    ];
}
