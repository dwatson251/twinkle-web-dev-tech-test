<?php


namespace Twinkl\Core\Logger;

use Twinkl\Core\Parser\Json\JsonEncodeParser;

/**
 * Class ErrorJsonLogger
 * @package Twinkl\Core\Logger
 */
class ErrorJsonLogger extends ErrorLogger
{
    /*
     * Output logic
     */
    
    public function buildProdOutput()
    {
        $this->output = (new JsonEncodeParser())
            ->setValue([
                'message'   => $this->returnErrorProdString(),
                'code'      => $this->er->getCode(),
            ])
            ->parse()
            ->getValue();
        return $this;
    }
    
    public function buildQaOutput()
    {
        $this->output = (new JsonEncodeParser())
            ->setValue([
                'message'   => $this->returnErrorQaString(),
                'code'      => $this->er->getCode(),
            ])
            ->parse()
            ->getValue();
        return $this;
    }
    
    public function buildDevOutput()
    {
        $this->output = (new JsonEncodeParser())
            ->setValue([
                'message'       => $this->returnErrorDevString(),
                'code'          => $this->er->getCode(),
                'file'          => $this->er->getFile(),
                'line'          => $this->er->getLine(),
                'stack_trace'   => $this->er->getTrace(),
            ])
            ->parse()
            ->getValue();
        return $this;
    }
}
