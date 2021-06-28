<?php


namespace Twinkl\Core\Parser\Exception;

use Error;
use Exception;
use LogicException;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Exception\ExceptionExt;
use Twinkl\Core\Exception\ParseException;
use Twinkl\Core\Helper\ClassExt\ReflectionClassHelper;
use Twinkl\Core\Parser\BaseParser;

/**
 * Class ExceptionParser
 * @package Twinkl\Core\Parser\Exception
 * @method Exception|null returnValue()
 * @method Exception|null getDefaultValue()
 * @method $this setDefaultValue(?Exception $defValue)
 */
class ExceptionParser extends BaseParser
{
    /*
     * Class logic
     */
    
    /**
     * @return string|null
     */
    public function getExceptionClass(): ?string
    {
        return $this->config['ex_class'] ?? null;
    }
    
    /**
     * @param string|null $exClass
     * @return $this
     */
    public function setExceptionClass(?string $exClass)
    {
        $this->config['ex_class'] = $this->parseExceptionClass($exClass);
        return $this;
    }
    
    /**
     * @return string
     */
    public function returnExceptionClass(): string
    {
        return $this->getExceptionClass() ?? ExceptionExt::class;
    }
    
    /**
     * @param string|null $exClass
     * @return string|null
     */
    protected function parseExceptionClass(?string $exClass): ?string
    {
        if (trim($exClass) == '') {
            return null;
        }
        if ($exClass instanceof Exception) {
            throw new LogicException(
                'Exception class is not sub class of ' . Exception::class,
                HttpConsts::CODE_SERVER_ERROR
            );
        }
        return $exClass;
    }
    
    /**
     * @param array|null $reflClassArgs
     * @return ReflectionClassHelper
     * @throws Exception
     */
    protected function createExceptionReflectionHelper(array $reflClassArgs = null): ReflectionClassHelper
    {
        return new ReflectionClassHelper($this->returnExceptionClass(), $reflClassArgs);
    }
    
    /**
     * @param ReflectionClassHelper $reflClassHlpr
     * @param array|null $reflClassArgs
     * @return Exception|ExceptionExt
     * @throws Exception
     */
    protected function createExceptionFromReflection(ReflectionClassHelper $reflClassHlpr, array $reflClassArgs = null)
    {
        if ($reflClassArgs !== null) {
            $reflClassHlpr->setReflectionClassArgs($reflClassArgs);
        }
        return $reflClassHlpr
            ->setReflectionClassArgs($reflClassArgs)
            ->build()
            ->getInstance();
    }
    
    /*
     * Parse logic
     */
    
    /**
     * @return $this
     * @throws ParseException
     */
    public function parse()
    {
        try {
            $this->reset();
            $this->value = $this->processParse($this->value);
            return $this;
        } catch (Exception $ex) {
            $prop = $this->prop ?? 'exception';
            $exClass = $this->returnExceptionClass();
            $exClass = $exClass ? " / {$exClass}" : '';
            $this->ex = new ParseException(
                "Unable to parse {$prop}.",
                HttpConsts::CODE_SERVER_ERROR,
                "{$prop} is not null / Exception{$exClass}.",
                "null / Exception{$exClass}.",
                $this->value,
                $prop,
                $this->context
            );
            throw $this->ex;
        }
    }
    
    /**
     * @param mixed|null $ex
     * @return Exception|ExceptionExt
     * @throws Exception
     */
    protected function processParse($ex)
    {
        if ($ex === null) {
            return null;
        }
        
        if (is_array($ex)) {
            return $this->processParseArray($ex);
        }
        if (!($ex instanceof Exception)) {
            $classes = Exception::class . " / {$this->returnExceptionClass()}";
            throw new LogicException(
                "Value is not an instance of {$classes}.",
                HttpConsts::CODE_SERVER_ERROR
            );
        }
        
        return $ex;
    }
    
    /**
     * @param array|null $exArr
     * @return Exception|ExceptionExt
     * @throws Exception
     */
    protected function processParseArray($exArr)
    {
        if (!$exArr) {
            return $this->defValue;
        }
        if (!is_array($exArr)) {
            throw new LogicException('Value is not an Array.', HttpConsts::CODE_SERVER_ERROR);
        }
        if (empty($exArr['message'])) {
            throw new LogicException('Value[message] is not defined.', HttpConsts::CODE_SERVER_ERROR);
        }
        
        return $this->createExceptionFromReflection(
            $this->createExceptionReflectionHelper(),
            [
                $exArr['message'],
                $exArr['code'] ?? HttpConsts::CODE_SERVER_ERROR,
                $exArr['reason'] ?? null,
                $exArr['expected'] ?? null,
            ]
        );
    }
}
