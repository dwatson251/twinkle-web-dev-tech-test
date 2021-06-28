<?php


namespace Twinkl\Core\Glob;

use Closure;
use Twinkl\Core\Consts\EnvConsts;
use Twinkl\Core\Env\{DebugEnv, DevEnv, IEnv, ProdEnv, QaEnv, TestEnv};
use Twinkl\Core\Db\Config\DbConfig;

/**
 * Class GlobalsGlob
 * @package Twinkl\Core\Glob
 */
class GlobalsGlob extends BaseArrayGlob
{
    /*
     * Getter logic
     */
    
    /**
     * @return array
     */
    public function getAll(): array
    {
        return $GLOBALS;
    }
    
    /*
     * Setter logic
     */
    
    public function setAll(?array $glob)
    {
        $GLOBALS = $glob ?? [];
        return $this;
    }
    
    /*
     * Env logic
     */
    
    /**
     * @return IEnv|null
     */
    public function getEnv(): ?IEnv
    {
        return $this->get('twinkl_env');
    }
    
    /**
     * @param IEnv|null $env
     * @return $this
     */
    public function setEnv(?IEnv $env)
    {
        return $this->set('twinkl_env', $env);
    }
    
    /**
     * @return IEnv
     */
    public function returnEnv()
    {
        return $this->getEnv() ?? new ProdEnv();
    }
    
    /**
     * @param int|null $mode
     * @return $this
     */
    public function buildEnvByMode(?int $mode)
    {
        $mode = $mode ?: EnvConsts::MODE_PROD;
        $envMap = $this->returnEnvMap();
        $env = isset($envMap[$mode]) ? $envMap[$mode]() : new ProdEnv();
        $this->setEnv($env);
        return $this;
    }
    
    /**
     * @return Closure[]
     */
    public function returnEnvMap(): array
    {
        return [
            EnvConsts::MODE_PROD => static function () {
                return new ProdEnv();
            },
            EnvConsts::MODE_QA => static function () {
                return new QaEnv();
            },
            EnvConsts::MODE_DEV => static function () {
                return new DevEnv();
            },
            EnvConsts::MODE_TEST => static function () {
                return new TestEnv();
            },
            EnvConsts::MODE_DEBUG => static function () {
                return new DebugEnv();
            },
        ];
    }
    
    /*
     * DB config logic
     */
    
    /**
     * @return DbConfig[]|null
     */
    public function getDbConfigs(): ?array
    {
        return $this->get('twinkl_db_configs');
    }
    
    /**
     * @param DbConfig[]|null $dbConfigs
     * @return $this
     */
    public function setDbConfigs(?array $dbConfigs)
    {
        return $this->set('twinkl_db_configs', $dbConfigs);
    }
    
    /**
     * @return DbConfig
     */
    public function returnDefaultDbConfig()
    {
        return $this->getDbConfigs()['default'] ?? new DbConfig();
    }
    
    /**
     * @param bool $asBool
     * @return bool|null
     */
    public function getUseSessAsDb(bool $asBool = false): ?bool
    {
        $useSessAsDb = $this->get('use_sess_as_db');
        return $asBool ? $useSessAsDb === true : $useSessAsDb;
    }
    
    /**
     * @param bool|null $useSessAsDb
     * @return $this
     */
    public function setUseSessAsDb(?bool $useSessAsDb)
    {
        return $this->set('use_sess_as_db', $useSessAsDb);
    }
}
