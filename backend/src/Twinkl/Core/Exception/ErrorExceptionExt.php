<?php

namespace Twinkl\Core\Exception;

use Exception;
use ErrorException;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Helper\Debug\StackTraceDebugHelper;
use Twinkl\Core\Helper\EvalExt\EvalHelper;
use Twinkl\Core\Logger\ExceptionLogger;
use Throwable;

/**
 * Class ErrorExceptionExt
 * @package Twinkl\Core\Exception
 */
class ErrorExceptionExt extends ErrorException
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
     * @param null|int $severity
     * @param null|string $reason
     * @param null|string $expected
     * @param null|string $filename
     * @param null|int $line
     * @param Throwable|null $previous
     */
    public function __construct(
        $message,
        $code = null,
        $severity = null,
        $reason = null,
        $expected = null,
        $filename = null,
        $line = null,
        $previous = null
    ) {
        if (!isset($filename, $line)) {
            $stackTraceItem = $this->getPreviousStackTrace();
            [$filename, $line] = [
                $filename ?? $stackTraceItem->getFile(),
                $line ?? $stackTraceItem->getLine(),
            ];
        }
        
        parent::__construct(
            $message ?? 'Unexpected error.',
            $code ?: HttpConsts::CODE_SERVER_ERROR,
            $severity ?: E_ERROR,
            $filename ?? '',
            $line ?? 0,
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
        $evalHlpr = new EvalHelper();
        $prefix = $prefix ?? ' | ';
        return implode(
            $prefix,
            array_filter([
                !$evalHlpr->setSource($this->reason)->isEmptyStr() ? $this->reason : '',
                !$evalHlpr->setSource($this->expected)->isEmptyStr() ? $this->expected : '',
            ])
        );
    }
    
    /*
     * Stack trace logic
     */
    
    protected function getPreviousStackTrace()
    {
        return (new StackTraceDebugHelper())
            ->setAsStackTraceItem(true)
            ->build()
            ->returnPreviousStackTrace();
    }
}