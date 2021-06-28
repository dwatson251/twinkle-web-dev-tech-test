<?php

namespace Twinkl\Core\Parser\String;

use Exception;
use LogicException;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Exception\ParseException;
use Twinkl\Core\Helper\EvalExt\EvalHelper;
use Twinkl\Core\Parser\BaseParser;

/**
 * Class StringParser
 * @package Twinkl\Core\Parser\String
 * @method string|null returnValue()
 * @method string|null getDefaultValue()
 * @method $this setDefaultValue(?string $defValue)
 */
class StringParser extends BaseParser
{
    /*
     * Parse logic
     */
    
    /**
     * @return $this
     * @throws ParseException
     */
    public function parse()
    {
        try {
            $this->reset();
            $this->value = $this->processParse($this->value);
            return $this;
        } catch (Exception $ex) {
            $prop = $this->prop ?? 'string';
            $this->ex = new ParseException(
                "Unable to parse {$prop}.",
                HttpConsts::CODE_SERVER_ERROR,
                "{$prop} is not null / string / number.",
                'null / string / number.',
                $this->value,
                $prop,
                $this->context
            );
            throw $this->ex;
        }
    }
    
    /**
     * @param mixed $str
     * @return string|null
     * @throws Exception
     */
    protected function processParse($str): ?string
    {
        if ($str === null) {
            return $this->defValue;
        }
        if (!(new EvalHelper($str))->isNonBoolScalar()) {
            throw new LogicException(
                'Value is not a non-bool scalar.',
                HttpConsts::CODE_SERVER_ERROR
            );
        }
        return (string) $str;
    }
}
