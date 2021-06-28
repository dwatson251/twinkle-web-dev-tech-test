<?php


namespace Twinkl\Core\Parser\Exception;

use Error;
use Exception;
use LogicException;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Exception\ExceptionExt;
use Twinkl\Core\Exception\ErrorExceptionExt;
use Twinkl\Core\Exception\ParseException;
use Twinkl\Core\Helper\ClassExt\ReflectionClassHelper;
use Twinkl\Core\Parser\BaseParser;

/**
 * Class ErrorToExceptionParser
 * @package Twinkl\Core\Parser\Exception
 * @property Error|null $src
 * @method Error|null getSource()
 * @method $this setSource(?Error $src)
 */
class ErrorToExceptionParser extends ExceptionParser
{
    /*
     * Class logic
     */
    
    /**
     * @return string
     */
    public function returnExceptionClass(): string
    {
        return $this->getExceptionClass() ?? ErrorExceptionExt::class;
    }
    
    /*
     * Parse logic
     */
    
    /**
     * @param mixed|null $ex
     * @return Exception|ErrorExceptionExt
     * @throws Exception
     */
    protected function processParse($ex)
    {
        if ($ex === null) {
            return $ex;
        }
        if ($ex instanceof Error) {
            return $this->processParseError($ex);
        }
        return parent::processParse($ex);
    }
    
    /**
     * @param mixed|null $err
     * @return Exception|ErrorExceptionExt
     * @throws Exception
     */
    protected function processParseError($err)
    {
        if ($err === null) {
            return $err;
        }
        if (!($err instanceof Error)) {
            throw new LogicException(
                'Value is not an instance of ' . Error::class . '.',
                HttpConsts::CODE_SERVER_ERROR
            );
        }
        
        return $this->createExceptionFromReflection(
            $this->createExceptionReflectionHelper(),
            [
                $err->getMessage(),
                $err->getCode(),
                null,
                null,
                null,
                $err->getFile(),
                $err->getLine(),
                $err->getPrevious(),
            ]
        );
    }
}
