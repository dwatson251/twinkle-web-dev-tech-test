<?php


namespace Twinkl\Core\Env;


use Twinkl\Core\Consts\EnvConsts;

/**
 * Class TestEnv
 * @package Twinkl\Core\Env
 */
class TestEnv extends BaseEnv
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
        $this->mode = EnvConsts::MODE_TEST;
        $this->errReporting = EnvConsts::ERR_REPORTING_TEST;
        $this->logLvl = EnvConsts::LOG_LVL_TEST;
        return $this;
    }
}