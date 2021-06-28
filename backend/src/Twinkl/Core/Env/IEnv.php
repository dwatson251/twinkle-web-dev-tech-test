<?php


namespace Twinkl\Core\Env;


/**
 * Class IEnv
 * @package Twinkl\Core\Env
 */
interface IEnv
{
    /**
     * @return int|null
     */
    public function getMode(): ?int;
    
    /**
     * @param int|null $mode
     * @return $this
     */
    public function setMode(?int $mode);
    
    /**
     * @return int|null
     */
    public function getErrorReporting(): ?int;
    
    /**
     * @param int|null $errReporting
     * @return $this
     */
    public function setErrorReporting(?int $errReporting);
    
    /**
     * @return int|null
     */
    public function getLogLevel(): int;
    
    /**
     * @param int|null $logLvl
     * @return $this
     */
    public function setLogLevel(?int $logLvl);
    
    /**
     * @return $this
     */
    public function build();
}
