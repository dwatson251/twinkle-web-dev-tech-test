<?php


use Twinkl\Core\Handler\Error\{RootErrorHandler, RootShutdownErrorHandler};
use Twinkl\Core\Handler\Exception\RootExceptionHandler;
use Twinkl\Core\Parser\Exception\ErrorToExceptionParser;

if (!function_exists('twinklShutDownHandler')) {
    function twinklShutdownHandler()
    {
        (new RootShutdownErrorHandler())
            ->buildError()
            ->run();
    }
}
register_shutdown_function('twinklShutdownHandler');

if (!function_exists('twinklExceptionHandler')) {
    /**
     * @param Exception|Error $ex
     */
    function twinklExceptionHandler($ex) {
        $ex = (new ErrorToExceptionParser($ex))
            ->parse()
            ->returnValue();
        (new RootExceptionHandler($ex))->run();
    }
}
set_exception_handler('twinklExceptionHandler');

if (!function_exists('twinklErrorHandler')) {
    /**
     * @param int $errno
     * @param string|null $errstr
     * @param string|null $errfile
     * @param int|null $errline
     */
    function twinklErrorHandler(
        $errno,
        $errstr,
        $errfile = null,
        $errline = null
    ) {
        (new RootErrorHandler())
            ->parseRuntimeError(
                (int) $errno,
                $errstr,
                $errfile,
                $errline
            )
            ->run();
    }
}
set_error_handler('twinklErrorHandler');
