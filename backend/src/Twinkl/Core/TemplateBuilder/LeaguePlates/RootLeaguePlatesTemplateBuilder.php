<?php

namespace Twinkl\Core\TemplateBuilder\LeaguePlates;

use Twinkl\Core\Consts\TemplateConsts;

/**
 * Class RootLeaguePlatesTemplateBuilder
 * @package Twinkl\Core\TemplateBuilder\LeaguePlates
 */
class RootLeaguePlatesTemplateBuilder extends LeaguePlatesTemplateBuilder
{
    /*
     * Consts
     */
    
    public const FLDS_DEFAULT = [
        TemplateConsts::DIR_CORE            => TemplateConsts::FLD_CORE,
        TemplateConsts::DIR_CORE_LAYOUT     => TemplateConsts::FLD_LAYOUT,
        TemplateConsts::DIR_CORE_PARTIAL    => TemplateConsts::FLD_PARTIAL,
        TemplateConsts::DIR_ERR             => TemplateConsts::FLD_ERR,
        TemplateConsts::DIR_DASH            => TemplateConsts::FLD_DASH,
    ];
    
}
