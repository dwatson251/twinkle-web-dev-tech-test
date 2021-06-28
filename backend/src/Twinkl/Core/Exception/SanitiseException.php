<?php


namespace Twinkl\Core\Exception;

use Throwable;
use Twinkl\Core\FilterVar\FilterVarDefinition;

/**
 * Class SanitiseException
 * @package Twinkl\Core\Exception
 */
class SanitiseException extends ExceptionExt
{
    /*
     * Properties
     */
    
    /**
     * @var mixed|null
     */
    protected $value;
    /**
     * @var string|null
     */
    protected $prop;
    /**
     * @var mixed|null
     */
    protected $context;
    /**
     * @var FilterVarDefinition|null
     */
    protected $fvd = [];
    
    /*
     * Init logic
     */
    
    public function __construct(
        $message,
        $code = null,
        string $reason = null,
        string $expected = null,
        $value = null,
        string $prop = null,
        $context = null,
        FilterVarDefinition $fvd = null,
        Throwable $previous = null
    ) {
        parent::__construct(
            $message,
            $code,
            $reason,
            $expected,
            $previous
        );
        $this->value = $value;
        $this->prop = $prop;
        $this->context = $context;
        $this->fvd = $fvd;
    }
    
    /*
     * Value logic
     */
    
    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /*
     * Property logic
     */
    
    /**
     * @return string|null
     */
    public function getProperty()
    {
        return $this->prop;
    }
    
    /*
     * Context logic
     */
    
    /**
     * @return string|null
     */
    public function getContext()
    {
        return $this->context;
    }
    
    /*
     * Filter var definition logic
     */
    
    /**
     * @return FilterVarDefinition|null
     */
    public function getFilterVarDefinition()
    {
        return $this->fvd;
    }
}
