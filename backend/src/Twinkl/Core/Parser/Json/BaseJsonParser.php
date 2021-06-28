<?php


namespace Twinkl\Core\Parser\Json;

use Exception;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Exception\ParseException;
use Twinkl\Core\Parser\BaseParser;

/**
 * Class BaseJsonParser
 * @package Twinkl\Core\Parser\Json
 */
abstract class BaseJsonParser extends BaseParser
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
     * Init logic
     */
    
    public function __construct(
        $value = null,
        $defValue = null,
        string $prop = null,
        $context = null,
        array $config = null
    ) {
        parent::__construct(
            $value,
            $defValue,
            $prop,
            $context,
            array_replace(
                ['assoc' => true],
                $config ?? []
            )
        );
    }
    
    /*
     * Config logic
     */
    
    /**
     * @param bool $asBool
     * @return bool|null
     */
    public function getAssoc(bool $asBool = false): ?bool
    {
        $assoc = $this->config['assoc'] ?? null;
        return $asBool ? $assoc === true : $assoc;
    }
    
    /**
     * @param bool|null $assoc
     * @return $this
     */
    public function setAssoc(?bool $assoc)
    {
        $this->config['assoc'] = $assoc;
        return $this;
    }
    
    /**
     * @return int|null
     */
    public function getOptions(): ?int
    {
        return $this->config['options'] ?? null;
    }
    
    /**
     * @param int|null $opts
     * @return $this
     */
    public function setOptions(?int $opts)
    {
        $this->config['options'] = $opts;
        return $this;
    }
    
    /**
     * @return int|null
     */
    public function getDepth(): ?int
    {
        return $this->config['depth'] ?? null;
    }
    
    /**
     * @param int|null $depth
     * @return $this
     */
    public function setDepth(?int $depth)
    {
        $this->config['depth'] = $depth;
        return $this;
    }
    
    
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
                "Encountered an error whilst {$this->returnEncodeType()} JSON.",
                HttpConsts::CODE_SERVER_ERROR,
                "Error Code: {$this->jsonErCode}"
                . " | Error Message: {$this->jsonErMsg}",
                null,
                $this->value,
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
