<?php

defined('__DIR__PUBLIC__') or define('__DIR__PUBLIC__', __DIR__ . '/../public');
defined('__DIR__BE__') or define('__DIR__BE__', __DIR__);

require_once __DIR__BE__ . '/vendor/autoload.php';
require_once __DIR__BE__ . '/hooks/error_handler.php';
require_once __DIR__BE__ . '/config/config.php';
require_once __DIR__BE__ . '/config/session.php';