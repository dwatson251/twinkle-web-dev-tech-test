<?php


namespace Twinkl\Core\Logger;

use Closure;
use Exception;
use Twinkl\Core\Consts\EnvConsts;
use Twinkl\Core\Exception\ExceptionExt;
use Twinkl\Core\Helper\Debug\VarDumpDebugHelper;

/**
 * Class ExceptionLogger
 * @package Twinkl\Core\Logger
 */
class ExceptionLogger extends BaseLogger
{
    /*
     * Properties
     */
    
    /**
     * @var Exception|ExceptionExt
     */
    protected $ex;
    
    /*
     * Init logic
     */
    
    /**
     * ExceptionLogger constructor.
     * @param Exception $ex
     * @param int|null $outputTypeId
     * @param int|null $logLvl
     */
    public function __construct(Exception $ex, int $logLvl = null)
    {
        parent::__construct($logLvl);
        $this->setException($ex);
    }
    
    /*
     * Exception logic
     */
    
    /**
     * @return Exception
     */
    public function getException()
    {
        return $this->ex;
    }
    
    /**
     * @param Exception $ex
     * @return $this
     */
    public function setException(Exception $ex)
    {
        $this->ex = $ex;
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isExceptionExt()
    {
        return $this->ex instanceof ExceptionExt;
    }
    
    /*
     * Run logic
     */
    
    public function run()
    {
        $this->resetOutput();
        $outputBuilderMap = $this->returnOutputBuilderMap();
        $logLvl = $this->returnLogLevel();
        if (isset($outputBuilderMap[$logLvl])) {
            $outputBuilderMap[$logLvl]();
        } else {
            $this->buildProdOutput();
        }
        return $this;
    }
    
    /*
     * Output logic
     */
    
    /**
     * @return Closure[]
     */
    protected function returnOutputBuilderMap()
    {
        return [
            EnvConsts::LOG_LVL_PROD => function() {
                $this->buildProdOutput();
            },
            EnvConsts::LOG_LVL_QA => function() {
                $this->buildQaOutput();
            },
            EnvConsts::LOG_LVL_TEST => function() {
                $this->buildDevOutput();
            },
            EnvConsts::LOG_LVL_DEV => function() {
                $this->buildDevOutput();
            },
            EnvConsts::LOG_LVL_DEBUG => function() {
                $this->buildDebugOutput();
            },
        ];
    }
    
    /**
     * @return $this
     */
    public function buildProdOutput()
    {
        $this->output = $this->returnExceptionProdString();
        return $this;
    }
    
    /**
     * @return $this
     */
    public function buildQaOutput()
    {
        $this->output = $this->returnExceptionQaString();
        return $this;
    }
    
    /**
     * @return $this
     */
    public function buildDevOutput()
    {
        $this->output = $this->returnExceptionDevString();
        return $this;
    }
    
    /**
     * @return $this
     */
    public function buildDebugOutput()
    {
        $this->output = $this->returnExceptionDebugString();
        return $this;
    }
    
    /*
     * String logic
     */
    
    /**
     * @return string
     */
    public function returnExceptionProdString() : string
    {
        return $this->ex->getMessage();
    }
    
    /**
     * @return string
     */
    public function returnExceptionQaString() : string
    {
        return (
            $this->returnExceptionProdString()
            . ($this->isExceptionExt() ? $this->ex->toDetailsString() : '')
            . " | Code: {$this->ex->getCode()}"
        );
    }
    
    /**
     * @return string
     */
    public function returnExceptionDevString() : string
    {
        return (
            $this->returnExceptionQaString()
            . " | Line: {$this->ex->getLine()}"
            . " | Stack Trace: {$this->ex->getTraceAsString()}"
        );
    }
    
    /**
     * @return string
     */
    public function returnExceptionDebugString() : string
    {
        return (new VarDumpDebugHelper($this->ex))->dump();
    }
}
