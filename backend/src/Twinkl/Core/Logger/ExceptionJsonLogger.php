<?php

namespace Twinkl\Core\Logger;

use Exception;
use Twinkl\Core\Util\JsonUtil;

/**
 * Class ExceptionJsonLogger
 * @package Twinkl\Core\Logger
 */
class ExceptionJsonLogger extends ExceptionLogger
{
    /*
     * Output logic
     */
    
    public function buildProdOutput()
    {
        $this->output = JsonUtil::getInstance()->encode([
            'message'   => $this->returnExceptionProdString(),
            'code'      => $this->ex->getCode(),
        ]);
        return $this;
    }
    
    public function buildQaOutput()
    {
        $isExceptionExt = $this->isExceptionExt();
        $this->output = JsonUtil::getInstance()->encode([
            'message'   => $this->returnExceptionQaString(),
            'code'      => $this->ex->getCode(),
            'reason'    => $isExceptionExt ? $this->ex->getReason() : null,
            'expected'  => $isExceptionExt ? $this->ex->getExpected() : null,
        ]);
        return $this;
    }
    
    public function buildDevOutput()
    {
        $isExceptionExt = $this->isExceptionExt();
        $this->output = JsonUtil::getInstance()->encode([
            'message'       => $this->returnExceptionDevString(),
            'code'          => $this->ex->getCode(),
            'reason'        => $isExceptionExt ? $this->ex->getReason() : null,
            'expected'      => $isExceptionExt ? $this->ex->getExpected() : null,
            'file'          => $this->ex->getFile(),
            'line'          => $this->ex->getLine(),
            'stack_trace'   => $this->ex->getTrace(),
        ]);
        return $this;
    }
}
