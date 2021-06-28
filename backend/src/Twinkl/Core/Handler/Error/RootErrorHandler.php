<?php


namespace Twinkl\Core\Handler\Error;

use Error;
use Exception;
use LogicException;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Exception\ErrorExceptionExt;
use Twinkl\Core\Handler\BaseHandler;

/**
 * Class RootErrorHandler
 * @package Twinkl\Core\Handler\Error
 */
class RootErrorHandler extends BaseHandler
{
    /*
     * Properties
     */
    
    /**
     * @var Error|null
     */
    protected $err;
    /**
     * @var ErrorExceptionExt|null
     */
    protected $ex;
    
    /*
     * Init logic
     */
    
    /**
     * RootErrorHandler constructor.
     * @param Error|null $err
     * @param ErrorExceptionExt|null $ex
     * @param array|null $config
     */
    public function __construct(Error $err = null, ErrorExceptionExt $ex = null, array $config = null)
    {
        parent::__construct($config);
        $this
            ->setError($err)
            ->setException($ex);
    }
    
    /*
     * Error logic
     */
    
    /**
     * @return Error
     */
    public function getError()
    {
        return $this->err;
    }
    
    /**
     * @param ErrorExceptionExt $er
     * @return $this
     */
    public function setError(?Error $er)
    {
        $this->err = $er;
        return $this;
    }
    
    /**
     * @param Error|null $err
     * @return $this
     */
    public function parseError(?Error $err)
    {
        $this->ex = !$err ?
            null
            : new ErrorExceptionExt(
                $err->getMessage(),
                $err->getCode(),
                null,
                null,
                null,
                $err->getFile(),
                $err->getLine()
            );
        return $this;
    }
    
    /**
     * @param int $errno
     * @param string|null $errstr
     * @param string|null $errfile
     * @param int|null $errline
     * @return $this
     */
    public function parseRuntimeError(
        int $errno,
        ?string $errstr,
        string $errfile = null,
        int $errline = null
    ) {
        $this->err = new Error($errstr, HttpConsts::CODE_SERVER_ERROR);
        $this->ex = new ErrorExceptionExt(
            $errstr,
            null,
            $errno,
            null,
            null,
            $errfile,
            $errline
        );
        return $this;
    }
    
    /*
     * Exception logic
     */
    
    /**
     * @return ErrorExceptionExt|null
     */
    public function getException(): ?ErrorExceptionExt
    {
        return $this->ex;
    }
    
    /**
     * @param ErrorExceptionExt|null $ex
     * @return $this
     */
    public function setException(?ErrorExceptionExt $ex)
    {
        $this->ex = $ex;
        return $this;
    }
    
    /*
     * Error reporting logic
     */
    
    /**
     * @return bool
     */
    public function isIgnoredErrorReporting(): bool
    {
        return (
            !$this->ex
            || error_reporting() === 0
        );
    }
    
    /*
     * Run logic
     */
    
    /**
     * @return $this
     * @throws Exception|ErrorExceptionExt
     */
    public function run()
    {
        if (!$this->ex) {
            $this->parseError($this->err);
            if (!$this->err) {
                throw new LogicException(
                    'ErrorException / Error is not defined.',
                    HttpConsts::CODE_SERVER_ERROR
                );
            }
        }
        
        if ($this->isIgnoredErrorReporting()) {
            // This error code is not included in error_reporting
            return $this;
        }
        
        throw $this->ex;
    }
}
