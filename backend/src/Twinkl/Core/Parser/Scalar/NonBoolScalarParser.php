<?php

namespace Twinkl\Core\Parser\Scalar;

use Exception;
use LogicException;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Exception\ParseException;
use Twinkl\Core\Parser\BaseParser;

/**
 * Class NonBoolScalarParser
 * @package Twinkl\Core\Parser\Scalar
 */
class NonBoolScalarParser extends BaseParser
{
    /*
     * Parse logic
     */
    
    public function parse()
    {
        try {
            $this->reset();
            $this->value = $this->processParse($this->value);
            return $this;
        } catch (Exception $ex) {
            $prop = $this->prop ?? 'non-bool scalar';
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
     * @param mixed $scalar
     * @return mixed|null
     */
    public function processParse($scalar)
    {
        if ($scalar === null) {
            return $this->defValue;
        }
        if (!is_scalar($scalar)
            || is_bool($scalar)
        ) {
            throw new LogicException('Value is not a string / number.', HttpConsts::CODE_SERVER_ERROR);
        }
        return $scalar;
    }
}
