<?php

namespace Twinkl\Core\Exception;

use Exception;
use Throwable;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Logger\ExceptionLogger;
use Twinkl\Core\Util\EvalUtil;

/**
 * Class ExceptionExt
 * @package Twinkl\Core\Exception
 */
class ExceptionExt extends Exception
{
    /*
     * Properties
     */
    
    /**
     * @var string|null
     */
    protected $reason;
    /**
     * @var string|null
     */
    protected $expected;
    
    /**
     * ExceptionExt constructor.
     * @param string $message
     * @param null|int $code
     * @param null|string $reason
     * @param null|string $expected
     * @param Throwable|null $previous
     */
    public function __construct(
        $message,
        $code = null,
        $reason = null,
        $expected = null,
        Throwable $previous = null
    ) {
        parent::__construct(
            $message ?? 'Unexpected error.',
            $code ?: HttpConsts::CODE_SERVER_ERROR,
            $previous
        );
        $this->reason = $reason;
        $this->expected = $expected;
    }
    
    /*
     * Magic method
     */
    
    public function __toString()
    {
        try {
            return (new ExceptionLogger($this))
                ->run()
                ->getOutput() ?? '';
        } catch (Exception $ex) {
            return $ex->__toString();
        }
    }
    
    /*
     * Reason logic
     */
    
    /**
     * @return string|null
     */
    public function getReason()
    {
        return $this->reason;
    }
    
    /*
     * Expected logic
     */
    
    /**
     * @return string|null
     */
    public function getExpected()
    {
        return $this->expected;
    }
    
    /*
     * String logic
     */
    
    /**
     * @return string
     */
    public function toRawString(): string
    {
        return parent::__toString();
    }
    
    /**
     * @param string|null $prefix
     * @return string
     */
    public function toDetailsString(string $prefix = null): string
    {
        $evalUtil = EvalUtil::getInstance();
        $prefix = $prefix ?? ' | ';
        return implode(
            $prefix,
            array_filter([
                !$evalUtil->isEmptyStr($this->reason) ? $this->reason : '',
                !$evalUtil->isEmptyStr($this->expected) ? $this->expected : '',
            ])
        );
    }
}
