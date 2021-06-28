<?php


namespace Twinkl\Core\Logger;


use Exception;
use Twinkl\Core\Glob\GlobalsGlob;

/**
 * Class BaseLogger
 * @package Twinkl\Core\Logger
 */
abstract class BaseLogger
{
    /*
     * Properties
     */
    
    /**
     * @var int|null
     */
    protected $logLvl;
    /**
     * @var int|null
     */
    protected $errReportingLvl;
    /**
     * @var string|null
     */
    protected $output;
    
    /*
     * Init logic
     */
    
    /**
     * BaseLogger constructor.
     * @param int|null $logLvl
     */
    public function __construct(int $logLvl = null)
    {
        $this->logLvl = $logLvl;
    }
    
    /*
     * Magic methods
     */
    
    public function __toString()
    {
        return (string) $this->getOutput();
    }
    
    /*
     * Log level logic
     */
    
    /**
     * @return int|null
     */
    public function getLogLevel()
    {
        return $this->logLvl;
    }
    
    /**
     * @param int|null $logLvl
     * @return $this
     * @throws Exception
     */
    public function setLogLevel(?int $logLvl)
    {
        $this->logLvl = $logLvl;
        return $this;
    }
    
    /**
     * @return int
     */
    public function returnLogLevel(): int
    {
        return $this->logLvl ?? (new GlobalsGlob())->returnEnv()->getLogLevel();
    }
    
    /*
     * Error Reporting level logic
     */
    
    /**
     * @return int|null
     */
    public function getErrorReportingLevel(): ?int
    {
        return $this->errReportingLvl;
    }
    
    /**
     * @param int|null $errrReportingLvl
     * @return $this
     */
    public function setErrorReportingLevel(?int $errReportingLvl)
    {
        $this->errReportingLvl = $errReportingLvl;
        return $this;
    }
    
    /*
     * Output logic
     */
    
    /**
     * @return string|null
     */
    public function getOutput()
    {
        return $this->output;
    }
    
    /**
     * @return $this
     */
    public function resetOutput()
    {
        $this->output = null;
        return $this;
    }
    
    /*
     * Run logic
     */
    
    /**
     * @return $this
     * @throws Exception
     */
    abstract public function run();
}
