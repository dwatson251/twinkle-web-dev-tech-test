<?php

namespace Twinkl\Core\Parser\String;

/**
 * Class StringTrimParser
 * @package Twinkl\Core\Parser\String
 */
class StringTrimParser extends StringParser
{
    /*
     * Parse logic
     */
    
    protected function processParse($str): ?string
    {
        if ($str === null) {
            return $this->defValue;
        }
        $str = parent::processParse($str);
        return trim($str);
    }
}
