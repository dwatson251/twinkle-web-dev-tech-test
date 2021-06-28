<?php

use Twinkl\Core\Consts\{DbConsts, EnvConsts};
use Twinkl\Core\Glob\GlobalsGlob;
use Twinkl\Core\Db\Config\DbConfig;
use Twinkl\Eloquent\Util\EloquentUtils;

(new GlobalsGlob())
    ->buildEnvByMode(
        getenv(EnvConsts::KEY_TWKL_ENV_MODE) ?: EnvConsts::LOG_LVL_DEBUG
    )
    ->setDbConfigs([
        'default' => (new DbConfig())
            ->setDriver(getenv(EnvConsts::KEY_TWKL_DB_DRIVER) ?: DbConsts::DRIVER_MYSQL)
            ->setHost(getenv(EnvConsts::KEY_TWKL_DB_HOST) ?: DbConsts::HOST_DEV)
            ->setDatabase(getenv(EnvConsts::KEY_TWKL_DB_DB) ?: DbConsts::DB_DEV)
            ->setUsername(getenv(EnvConsts::KEY_TWKL_DB_USERNAME) ?: DbConsts::USERNAME_DEV)
            ->setPassword(getenv(EnvConsts::KEY_TWKL_DB_PWD) ?: null)
    ]);

EloquentUtils::getInstance()->initConnections();