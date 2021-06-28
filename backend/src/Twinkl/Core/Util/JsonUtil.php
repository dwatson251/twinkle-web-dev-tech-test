<?php

namespace Twinkl\Core\Util;

use Exception;
use Twinkl\Core\Consts\Consts;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\CustomTrait\SingletonTrait;
use Twinkl\Core\Exception\ExceptionExt;

/**
 * Class JsonUtil
 * @package Twinkl\Core\Util
 */
class JsonUtil
{
    /*
     * Traits
     */
    
    use SingletonTrait;
    
    /*
     * Encode logic
     */
    
    /**
     * @param mixed $value
     * @param int|null $opts
     * @param int|null $depth
     * @return string
     * @throws Exception
     */
    public function encode($value, int $opts = null, int $depth = null)
    {
        try {
            if ($value === null) {
                return null;
            }
            $return = json_encode(
                $value,
                $opts ?? Consts::JSON_OPTS_DEF,
                $depth ?? Consts::JSON_DEPTH_DEF
            );
            $this->validateJsonError();
            return $return;
        } catch (Exception $ex) {
            throw new ExceptionExt(
                'Unable to encode value as JSON.',
                $ex->getCode(),
                $ex->getMessage(),
                null,
                $ex
            );
        }
    }
}
