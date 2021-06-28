<?php

defined('__DIR__BE__') or define('__DIR__BE__', __DIR__ . '/..');

require_once __DIR__BE__ . '/vendor/autoload.php';

use Twinkl\Core\Consts\EnvConsts;

putenv(EnvConsts::KEY_TWKL_ENV_MODE . '=' . EnvConsts::MODE_TEST);

require_once __DIR__BE__ . '/bootstrap.php';