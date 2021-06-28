<?php


namespace Twinkl\Core\Parser\Json;


use Exception;
use Twinkl\Core\Consts\Consts;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Exception\ExceptionExt;
use Twinkl\Core\Exception\ParseException;

/**
 * Class JsonDecodeParser
 * @package Twinkl\Core\Parser\Json
 */
class JsonDecodeParser extends BaseJsonParser
{
    /*
     * Parse logic
     */
    
    public function parse()
    {
        try {
            $this->reset();
            $this->value = $this->decode($this->value);
            return $this;
        } catch (Exception $ex) {
            $prop = $this->prop ?? 'json decode';
            $this->ex = new ParseException(
                "Unable to parse {$prop}.",
                HttpConsts::CODE_SERVER_ERROR,
                "{$prop} is not null / json string.",
                'null / json string.',
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
     * @return array|object
     * @throws Exception
     */
    protected function decode($value)
    {
        if ($value === null) {
            return $this->defValue;
        }
        $this->encTypeId = static::ENC_TYPE_ID_DEC;
        $value = json_decode(
            $value,
            $this->getAssoc(true),
            $this->getDepth() ?? Consts::JSON_DEPTH_DEF,
            $this->getOptions() ?? Consts::JSON_OPTS_DEF
        );
        $this->validateJsonError();
        return $value;
    }
}
