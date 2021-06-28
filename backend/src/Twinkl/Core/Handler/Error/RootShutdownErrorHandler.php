<?php


namespace Twinkl\Core\Handler\Error;

use Closure;
use Error;
use LogicException;
use Twinkl\Core\Consts\EnvConsts;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Exception\ErrorExceptionExt;
use Twinkl\Core\Glob\GlobalsGlob;
use Twinkl\Core\Handler\BaseHandler;

/**
 * Class RootShutdownErrorHandler
 * @package Twinkl\Core\Handler\Error
 */
class RootShutdownErrorHandler extends BaseHandler
{
    /*
     * Properties
     */
    
    /**
     * @var Error|null
     */
    protected $err;
    /**
     * @var ErrorExceptionExt|null
     */
    protected $ex;
    /**
     * @var string|null
     */
    protected $output;
    
    /*
     * Init logic
     */
    
    /**
     * RootShutdownErrorHandler constructor.
     * @param ErrorExceptionExt|null $ex
     * @param Error|null $err
     * @param bool|null $triggerOutput
     * @param bool|null $triggerExit
     * @param array|null $config
     */
    public function __construct(
        ErrorExceptionExt $ex = null,
        Error $err = null,
        ?bool $triggerOutput = true,
        ?bool $triggerExit = true,
        array $config = null
    ) {
        parent::__construct($config);
        $this
            ->setError($err)
            ->setException($ex)
            ->setTriggerOutput($triggerOutput)
            ->setTriggerExit($triggerExit);
    }
    
    /*
     * Error logic
     */
    
    /**
     * @return Error|null
     */
    public function getError(): ?Error
    {
        return $this->err;
    }
    
    /**
     * @param Error|null $err
     * @return $this
     */
    public function setError(?Error $err)
    {
        $this->err = $err;
        return $this;
    }
    
    /**
     * @return ErrorExceptionExt|null
     */
    public function getException(): ?ErrorExceptionExt
    {
        return $this->ex;
    }
    
    /**
     * @param ErrorExceptionExt|null $ex
     * @return $this
     */
    public function setException(?ErrorExceptionExt $ex)
    {
        $this->ex = $ex;
        return $this;
    }
    
    /**
     * @param array|null $err
     * @return $this
     */
    public function parseRuntimeError(?array $err) {
        if (!$err) {
            $this->err = null;
            $this->ex = null;
            return $this;
        }
        $this->err = new Error(
            $err['message'] ?? 0,
            $err['code'] ?? null,
            $err['previous'] ?? null
        );
        $this->ex = new ErrorExceptionExt(
            $err['message'] ?? 0,
            $err['code'] ?? null,
            $err['type'] ?? 0,
            $err['reason'] ?? null,
            $err['expected'] ?? null,
            $err['file'] ?? null,
            $err['line'] ?? null,
            $err['previous'] ?? null
        );
        return $this;
    }
    
    /**
     * @param Error|null $err
     * @return $this
     */
    public function parseError(?Error $err) {
        if (!$err) {
            $this->ex = null;
            return $this;
        }
        $this->ex = new ErrorExceptionExt(
            $err->getMessage(),
            $err->getCode(),
            null,
            null,
            null,
            null,
            null,
            $err->getPrevious()
        );
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isIgnoredErrorReporting()
    {
        return (
            (!$this->ex && !$this->err)
            || error_reporting() === 0
        );
    }
    
    /**
     * @return array|null
     */
    protected function getLastRuntimeError(): ?array
    {
        return error_get_last();
    }
    
    /**
     * @return array|null
     */
    protected function pullLastRuntimeError(): ?array
    {
        $err = $this->getLastRuntimeError();
        error_clear_last();
        return $err;
    }
    
    /**
     * @return $this
     */
    public function buildError()
    {
        $err = $this->pullLastRuntimeError();
        if (empty($err['type'])) {
            [$this->err, $this->ex] = [null, null];
            return $this;
        }
        return $this->parseRuntimeError($err);
    }
    
    /*
     * Run logic
     */
    
    /**
     * @return $this
     * @throws ErrorExceptionExt
     */
    public function run()
    {
        if (!$this->ex) {
            if (!$this->err) {
                return $this;
            }
            $this->parseError($this->err);
            if (!$this->ex) {
                throw new LogicException('Exception is not defined.', HttpConsts::CODE_SERVER_ERROR);
            }
        }
        
        if ($this->isIgnoredErrorReporting()) {
            // This error code is not included in error_reporting
            return $this;
        }
        
        if ($this->getTriggerOutput(true)) {
            $this->buildOutput();
            echo $this->output;
        }
        
        if ($this->getTriggerExit(true)) {
            exit();
        }
        
        throw $this->ex;
    }
    
    /*
     * Output logic
     */
    
    /**
     * @param bool $asBool
     * @return bool|null
     */
    public function getTriggerOutput(bool $asBool = false): ?bool
    {
        $triggerOutput = $this->config['trigger_output'] ?? null;
        return $asBool ? $triggerOutput === true : $triggerOutput;
    }
    
    /**
     * @param bool|null $triggerOutput
     * @return $this
     */
    public function setTriggerOutput(?bool $triggerOutput)
    {
        $this->config['trigger_output'] = $triggerOutput;
        return $this;
    }
    
    /**
     * @return $this
     */
    public function buildOutput(int $logLvl = null)
    {
        if (!$this->ex) {
            $this->output = null;
            return $this;
        }
        
        $logLvl = $logLvl ?? (new GlobalsGlob())->returnEnv()->getLogLevel();
        $outputErrMsgCb = $this->returnOutputErrorMessageMap()[$logLvl] ?? null;
        $this->output = $outputErrMsgCb ?
            $outputErrMsgCb()
            : $this->returnProdOutputErrorMessage();
        
        return $this;
    }
    
    /**
     * @return Closure[]
     */
    public function returnOutputErrorMessageMap()
    {
        return [
            EnvConsts::LOG_LVL_PROD    => function () {
                return $this->returnProdOutputErrorMessage();
            },
            EnvConsts::LOG_LVL_DEV     => function () {
                return $this->returnDevOutputErrorMessage();
            },
            EnvConsts::LOG_LVL_DEBUG   => function () {
                return $this->returnDebugOutputErrorMessage();
            },
        ];
    }
    
    /**
     * @param ErrorExceptionExt|null $ex
     * @return string
     */
    public function returnProdOutputErrorMessage(): string
    {
        if (!$this->ex) {
            return '';
        }
        $errMsg = $this->ex->getMessage();
        if ($this->ex->getReason()) {
            $errMsg .= $ex->getReason();
        }
        $msg = (
            '<h2>Error:</h2>'
            . "<p>{$errMsg}</p>"
        );
        return $msg;
    }
    
    /**
     * @return string
     */
    public function returnDevOutputErrorMessage(): string
    {
        if (!$this->ex) {
            return '';
        }
        $msg = (
            '<h2>Error:</h2>'
            . '<p>' . print_r($this->ex, true) . '</p>'
        );
        return $msg;
    }
    
    /**
     * @return string
     */
    public function returnDebugOutputErrorMessage(): string
    {
        if (!$this->ex) {
            return '';
        }
        $msg = (
            '<h2>Error:</h2>'
            . '<p>' . print_r($this->ex, true) . '</p>'
            . '<h2>Stack Trace:</h2>'
            . '<p>' . print_r($this->ex->getTrace(), true) . '</p>'
        );
        return $msg;
    }
}
