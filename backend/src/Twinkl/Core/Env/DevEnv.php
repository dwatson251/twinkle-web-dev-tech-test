<?php


namespace Twinkl\Core\Env;


use Twinkl\Core\Consts\EnvConsts;

/**
 * Class DevEnv
 * @package Twinkl\Core\Env
 */
class DevEnv extends BaseEnv
{
    /*
     * Init logic
     */
    
    public function __construct(int $errReporting = null, int $logLvl = null)
    {
        $this->build();
        parent::__construct(
            $this->mode,
            $errReporting ?? $this->errReporting,
            $logLvl ?? $this->logLvl
        );
    }
    
    /*
     * Build logic
     */
    
    public function build()
    {
        $this->mode = EnvConsts::MODE_DEV;
        $this->errReporting = EnvConsts::ERR_REPORTING_DEV;
        $this->logLvl = EnvConsts::LOG_LVL_DEV;
        return $this;
    }
}