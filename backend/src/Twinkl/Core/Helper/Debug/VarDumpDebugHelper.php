<?php

namespace Twinkl\Core\Helper\Debug;

use Symfony\Component\VarDumper\VarDumper;
use Twinkl\Core\Helper\BaseHelper;

/**
 * Class VarDumpDebugHelper
 * @package Twinkl\Core\Helper\Debug
 */
class VarDumpDebugHelper extends BaseHelper
{
    /**
     * @return string
     */
    public function dump(): string
    {
        ob_start();
        VarDumper::dump($this->src);
        $return = ob_get_contents();
        ob_clean();
        return $return;
    }
}
