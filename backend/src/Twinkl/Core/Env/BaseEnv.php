<?php


namespace Twinkl\Core\Env;


use Twinkl\Core\Consts\EnvConsts;

/**
 * Class BaseEnvConfig
 * @package Twinkl\Core\Env
 */
abstract class BaseEnv implements IEnv
{
    /*
     * Properties
     */
    
    /**
     * @var int|null
     */
    protected $mode;
    /**
     * @var int|null
     */
    protected $errReporting;
    /**
     * @var int|null
     */
    protected $logLvl;
    
    /*
     * Init logic
     */
    
    /**
     * EnvConfig constructor.
     * @param int|null $mode
     * @param int|null $errReporting
     * @param int|null $logLvl
     */
    public function __construct(
        int $mode = null,
        int $errReporting = null,
        int $logLvl = null
    ) {
        $this
            ->setMode($mode)
            ->setLogLevel($logLvl)
            ->setErrorReporting($errReporting);
    }
    
    /*
     * Mode logic
     */
    
    /**
     * @return int|null
     */
    public function getMode(): ?int
    {
        return $this->mode;
    }
    
    /**
     * @param int|null $mode
     * @return $this
     */
    public function setMode(?int $mode)
    {
        $this->mode = $mode;
        return $this;
    }
    
    /*
     * Error reporting level logic
     */
    
    /**
     * @return int|null
     */
    public function getErrorReporting(): ?int
    {
        return $this->errReporting;
    }
    
    /**
     * @param int|null $errReporting
     * @return $this
     */
    public function setErrorReporting(?int $errReporting)
    {
        $this->errReporting = $errReporting;
        return $this;
    }
    
    /*
     * Log level logic
     */
    
    /**
     * @return int|null
     */
    public function getLogLevel(): int
    {
        return $this->logLvl;
    }
    
    /**
     * @param int|null $logLvl
     * @return $this
     */
    public function setLogLevel(?int $logLvl)
    {
        $this->logLvl = $logLvl;
        return $this;
    }
    
    /*
     * Build logic
     */
    
    /**
     * @return $this
     */
    abstract public function build();
}
