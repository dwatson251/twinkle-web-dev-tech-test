<?php


namespace Twinkl\Core\Consts;

/**
 * Class EnvConsts
 * @package Twinkl\Core\Consts
 */
class EnvConsts
{
    /*
     * Mode logic
     */
    
    public const MODE_PROD = 1;
    public const MODE_QA = 2;
    public const MODE_DEV = 3;
    public const MODE_TEST = 4;
    public const MODE_DEBUG = 5;
    
    /*
     * Error reporting level logic
     */
    
    public const ERR_REPORTING_LVL_ID_PROD = 1;
    public const ERR_REPORTING_LVL_ID_QA = 2;
    public const ERR_REPORTING_LVL_ID_DEV = 3;
    public const ERR_REPORTING_LVL_ID_TEST = 4;
    public const ERR_REPORTING_LVL_ID_DEBUG = 5;
    
    public const ERR_REPORTING_PROD = E_ALL & ~(E_STRICT | E_DEPRECATED | E_NOTICE | E_WARNING);
    public const ERR_REPORTING_QA = E_ALL & ~(E_STRICT | E_DEPRECATED | E_NOTICE);
    public const ERR_REPORTING_DEV = E_ALL & ~(E_STRICT | E_DEPRECATED);
    public const ERR_REPORTING_TEST = E_ALL & ~(E_STRICT | E_DEPRECATED);
    public const ERR_REPORTING_DEBUG = E_ALL ^ (E_STRICT | E_DEPRECATED | E_NOTICE | E_WARNING);
    
    /*
     * Logging level logic
     */
    
    public const LOG_LVL_PROD = 1;
    public const LOG_LVL_QA = 2;
    public const LOG_LVL_DEV = 3;
    public const LOG_LVL_TEST = 4;
    public const LOG_LVL_DEBUG = 5;
    
    /*
     * Keys logic
     */
    
    public const KEY_TWKL_ENV_MODE = 'TWINKL_ENV_MODE';
    
    public const KEY_TWKL_DB_DRIVER = 'TWINKL_DB_DRIVER';
    public const KEY_TWKL_DB_HOST = 'TWINKL_DB_HOST';
    public const KEY_TWKL_DB_DB = 'TWINKL_DB_DB';
    public const KEY_TWKL_DB_USERNAME = 'TWINKL_DB_USERNAME';
    public const KEY_TWKL_DB_PWD = 'TWINKL_DB_PWD';
}
