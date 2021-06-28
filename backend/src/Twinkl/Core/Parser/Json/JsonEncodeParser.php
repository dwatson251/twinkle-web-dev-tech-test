<?php


namespace Twinkl\Core\Parser\Json;


use Exception;
use Twinkl\Core\Consts\Consts;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Exception\ParseException;

/**
 * Class JsonEncodeParser
 * @package Twinkl\Core\Parser\Json
 */
class JsonEncodeParser extends BaseJsonParser
{
    public function parse()
    {
        try {
            $this->reset();
            $this->value = $this->encode($this->value);
            return $this;
        } catch (Exception $ex) {
            $prop = $this->prop ?? 'json encode';
            $this->ex = new ParseException(
                "Unable to parse {$prop}.",
                HttpConsts::CODE_SERVER_ERROR,
                "{$prop} is not null / object / array.",
                'null / object / array.',
                $this->value,
                $prop,
                $this->context
            );
            throw $this->ex;
        }
    }
    
    /*
     * Decode logic
     */
    
    /**
     * @param mixed $value
     * @return string
     * @throws Exception
     */
    protected function encode($value)
    {
        if ($value === null) {
            return $this->defValue;
        }
        $this->encTypeId = static::ENC_TYPE_ID_DEC;
        $value = json_encode(
            $value,
            $this->getOptions() ?? Consts::JSON_OPTS_DEF,
            $this->getDepth() ?? Consts::JSON_DEPTH_DEF
        );
        $this->validateJsonError();
        return $value;
    }
}
