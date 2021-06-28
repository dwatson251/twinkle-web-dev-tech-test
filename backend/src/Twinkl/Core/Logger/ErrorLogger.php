<?php


namespace Twinkl\Core\Logger;

use Closure;
use Error;
use Twinkl\Core\Consts\EnvConsts;
use Twinkl\Core\Helper\Debug\VarDumpDebugHelper;

/**
 * Class ErrorLogger
 * @package Twinkl\Core\Logger
 */
class ErrorLogger extends BaseLogger
{
    /*
     * Properties
     */
    
    /**
     * @var Error
     */
    protected $er;
    
    /**
     * ErrorLogger constructor.
     * @param Error $er
     * @param int|null $outputTypeId
     * @param int|null $logLvl
     */
    public function __construct(Error $er, int $logLvl = null)
    {
        parent::__construct($logLvl);
        $this->setError($er);
    }
    
    /*
     * Error logic
     */
    
    /**
     * @return Error
     */
    public function getError()
    {
        return $this->er;
    }
    
    /**
     * @param Error $er
     * @return $this
     */
    public function setError(Error $er)
    {
        $this->er = $er;
        return $this;
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
                $this->buildDebugOutput();
            },
        ];
    }
    
    /**
     * @return $this
     */
    public function buildProdOutput()
    {
        $this->output = $this->returnErrorProdString();
        return $this;
    }
    
    /**
     * @return $this
     */
    public function buildQaOutput()
    {
        $this->output = $this->returnErrorQaString();
        return $this;
    }
    
    /**
     * @return $this
     */
    public function buildDevOutput()
    {
        $this->output = $this->returnErrorDevString();
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
    public function returnErrorProdString() : string
    {
        return $this->er->getMessage();
    }
    
    /**
     * @return string
     */
    public function returnErrorQaString() : string
    {
        return (
            $this->returnErrorProdString()
            . " | Code: {$this->er->getCode()}"
        );
    }
    
    /**
     * @return string
     */
    public function returnErrorDevString() : string
    {
        return (
            $this->returnErrorQaString()
            . " | Line: {$this->er->getLine()}"
            . " | Stack Trace: {$this->er->getTraceAsString()}"
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
