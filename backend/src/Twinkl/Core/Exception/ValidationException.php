<?php


namespace Twinkl\Core\Exception;

use Throwable;

/**
 * Class ValidationException
 * @package Twinkl\Core\Exception
 */
class ValidationException extends ExceptionExt
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
    
    /*
     * Init logic
     */
    
    /**
     * ParseException constructor.
     * @param string $message
     * @param int|null $code
     * @param string|null $reason
     * @param string|null $expected
     * @param mixed|null $value
     * @param string|null $prop
     * @param mixed|null $context
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
     * @return mixed|null
     */
    public function getContext()
    {
        return $this->context;
    }
}
