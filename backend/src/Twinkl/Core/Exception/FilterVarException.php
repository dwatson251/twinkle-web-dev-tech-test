<?php


namespace Twinkl\Core\Exception;

use Throwable;
use Twinkl\Core\FilterVar\FilterVarDefinition;

/**
 * Class FilterVarException
 * @package Twinkl\Core\Exception
 */
class FilterVarException extends ParseException
{
    /*
     * Properties
     */
    
    /**
     * @var FilterVarDefinition|null
     */
    protected $fvd;
    
    /*
     * Init logic
     */
    
    /**
     * FilterVarException constructor.
     * @param string $message
     * @param int|null $code
     * @param string|null $reason
     * @param string|null $expected
     * @param mixed|null $value
     * @param string|null $prop
     * @param mixed|null $context
     * @param FilterVarDefinition|null $fvd
     * @param Throwable|null $previous
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
            $value,
            $prop,
            $context,
            $previous
        );
        $this->fvd = $fvd;
    }
    
    /*
     * Filter var logic
     */
    
    /**
     * @return FilterVarDefinition|null
     */
    public function getFilterVarDefinition()
    {
        return $this->fvd;
    }
}
