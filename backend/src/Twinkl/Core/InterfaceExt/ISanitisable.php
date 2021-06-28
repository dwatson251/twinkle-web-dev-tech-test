<?php

namespace Twinkl\Core\InterfaceExt;

use Exception;
use Twinkl\Core\Exception\SanitiseException;

/**
 * Interface ISanitisable
 * @package Twinkl\Core\InterfaceExt
 */
interface ISanitisable
{
    /**
     * @return $this
     * @throws Exception|SanitiseException
     */
    public function sanitise();
}
