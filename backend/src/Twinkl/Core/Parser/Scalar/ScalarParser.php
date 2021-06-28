<?php

namespace Twinkl\Core\Parser\Scalar;

use Exception;
use LogicException;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Exception\ParseException;
use Twinkl\Core\Parser\BaseParser;

/**
 * Class ScalarParser
 * @package Twinkl\Core\Parser\Scalar
 */
class ScalarParser extends BaseParser
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
            $prop = $this->prop ?? 'scalar';
            $this->ex = new ParseException(
                "Unable to parse {$prop}.",
                HttpConsts::CODE_SERVER_ERROR,
                "{$prop} is not null / string / number / bool.",
                'null / string / number / bool.',
                $this->value,
                $prop,
                $this->context
            );
            throw $this->ex;
        }
    }
    
    /**
     * @return mixed|null
     * @throws Exception
     */
    protected function processParse($scalar)
    {
        if ($scalar === null) {
            return $this->defValue;
        }
        if (!is_scalar($scalar)) {
            throw new LogicException('Value is not a scalar.', HttpConsts::CODE_SERVER_ERROR);
        }
        return $scalar;
    }
}
