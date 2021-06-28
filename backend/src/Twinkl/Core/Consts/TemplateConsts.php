<?php

namespace Twinkl\Core\Consts;

/**
 * Class TemplateConsts
 * @package Twinkl\Core\Consts
 */
class TemplateConsts
{
    public const FILE_EXT = 'view.php';
    
    public const DIR_VIEWS = __DIR__BE__ . '/views';
    public const DIR_CORE = self::DIR_VIEWS . '/core';
    public const DIR_CORE_LAYOUT = self::DIR_CORE . '/layout';
    public const DIR_CORE_PARTIAL = self::DIR_CORE . '/partial';
    public const DIR_ERR = self::DIR_VIEWS . '/error';
    public const DIR_DASH = self::DIR_VIEWS . '/dashboard';
    
    public const FLD_CORE = 'core';
    public const FLD_LAYOUT = 'layout';
    public const FLD_PARTIAL = 'partial';
    public const FLD_ERR = 'error';
    public const FLD_DASH = 'dashboard';
}
