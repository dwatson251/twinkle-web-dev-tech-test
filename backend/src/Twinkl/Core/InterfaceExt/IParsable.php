<?php

namespace Twinkl\Core\InterfaceExt;

use Exception;
use Twinkl\Core\Exception\ParseException;
use Twinkl\Core\Parser\BaseParser;

/**
 * Interface IParsable
 * @package Twinkl\Core\InterfaceExt
 */
interface IParsable
{
    /**
     * @return mixed
     */
    public function parse();
    
    /**
     * @return ?ParseException
     */
    public function getError(): ?ParseException;
    
    /**
     * @return bool
     */
    public function hasError(): bool;
}
