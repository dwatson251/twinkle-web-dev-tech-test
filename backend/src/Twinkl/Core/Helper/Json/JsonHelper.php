<?php


namespace Twinkl\Core\Helper\Json;

use Exception;
use Twinkl\Core\Consts\Consts;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Exception\ExceptionExt;
use Twinkl\Core\Exception\ParseException;
use Twinkl\Core\Helper\BaseHelper;

/**
 * Class JsonHelper
 * @package Twinkl\Core\Helper\Json
 */
class JsonHelper extends BaseHelper
{
    /*
     * Consts
     */
    
    public const ENC_TYPE_ID_ENC = 1;
    public const ENC_TYPE_ID_DEC = 2;
    public const ENC_TYPE_ENC = 'encode';
    public const ENC_TYPE_DEC = 'decode';
    
    /*
     * Properties
     */
    
    /**
     * @var mixed|null
     */
    protected $result;
    /**
     * @var int|null
     */
    protected $jsonErCode;
    /**
     * @var string|null
     */
    protected $jsonErMsg;
    /**
     * @var int|null
     */
    protected $encTypeId;
    
    /*
     * Encode type logic
     */
    
    /**
     * @return int|null
     */
    public function getEncodeTypeId(): ?int
    {
        return $this->encTypeId;
    }
    
    /**
     * @return string|null
     */
    public function returnEncodeType(): ?string
    {
        if (!$this->encTypeId) {
            return null;
        }
        return $this->returnEncodeTypeMap()[$this->encTypeId]['name'] ?? null;
    }
    
    /**
     * @return array
     */
    public function returnEncodeTypeMap(): array
    {
        return [
            static::ENC_TYPE_ID_ENC => ['name' => static::ENC_TYPE_ENC,],
            static::ENC_TYPE_ID_DEC => ['name' => static::ENC_TYPE_DEC,],
        ];
    }
    
    /*
     * Result logic
     */
    
    /**
     * @return mixed|null
     */
    public function getResult()
    {
        return $this->result;
    }
    
    /*
     * Encode logic
     */
    
    /**
     * @param int|null $opts
     * @param int|null $depth
     * @return $this
     * @throws Exception
     */
    public function encode(int $opts = null, int $depth = null)
    {
        try {
            if ($this->src === null) {
                return null;
            }
            $this->encTypeId = static::ENC_TYPE_ID_ENC;
            $this->result = json_encode(
                $this->src,
                $opts ?? Consts::JSON_OPTS_DEF,
                $depth ?? Consts::JSON_DEPTH_DEF
            );
            $this->validateJsonError();
            return $this;
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
    
    /*
     * Decode logic
     */
    
    /**
     * @param mixed $this->src
     * @param bool $assoc
     * @param int|null $opts
     * @param int|null $depth
     * @return array|object
     * @throws Exception
     */
    public function decode(bool $assoc = true, int $opts = null, int $depth = null)
    {
        try {
            if ($this->src === null) {
                return null;
            }
            $this->encTypeId = static::ENC_TYPE_ID_DEC;
            $this->result = json_decode(
                $this->src,
                $assoc,
                $depth ?? Consts::JSON_DEPTH_DEF,
                $opts ?? Consts::JSON_OPTS_DEF
            );
            $this->validateJsonError();
            return $this;
        } catch (Exception $ex) {
            throw new ExceptionExt(
                'Unable to decode JSON.',
                $ex->getCode(),
                $ex->getMessage(),
                null,
                $ex
            );
        }
    }
    
    /*
     * Error logic
     */
    
    /**
     * @return $this
     */
    public function updateJsonError()
    {
        $this->jsonErCode = json_last_error();
        $this->jsonErMsg = json_last_error_msg();
        return $this;
    }
    
    /**
     * @return $this
     * @throws Exception|ParseException
     */
    public function validateJsonError()
    {
        if ($this->jsonErCode !== JSON_ERROR_NONE) {
            throw new ParseException(
                'Encountered an error whilst encoding / decoding JSON.',
                HttpConsts::CODE_SERVER_ERROR,
                "Error Code: {$this->jsonErCode}"
                . " | Error Message: {$this->jsonErMsg}",
                null,
                $this->src,
                null,
                [
                    'encode_type_id'        => $this->encTypeId,
                    'encode_type'           => $this->returnEncodeType(),
                    'json_error_code'       => $this->jsonErCode,
                    'json_error_message'    => $this->jsonErMsg,
                ]
            );
        }
        return $this;
    }
}
