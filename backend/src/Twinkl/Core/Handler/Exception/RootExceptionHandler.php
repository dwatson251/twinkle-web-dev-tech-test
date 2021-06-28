<?php

namespace Twinkl\Core\Handler\Exception;

use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Twinkl\Core\Exception\ErrorExceptionExt;
use Twinkl\Core\Exception\ExceptionExt;
use Twinkl\Core\Handler\BaseHandler;
use Twinkl\Core\Logger\ExceptionJsonLogger;
use Twinkl\Core\Logger\ExceptionLogger;

/**
 * Class RootExceptionHandler
 * @package Twinkl\Core\Handler\Exception
 */
class RootExceptionHandler extends BaseHandler
{
    /*
     * Properties
     */
    
    /**
     * @var Exception|ExceptionExt
     */
    protected $ex;
    /**
     * @var Request|null
     */
    protected $request;
    /**
     * @var Response|null
     */
    protected $response;
    
    /*
     * Init logic
     */
    
    /**
     * RootExceptionHandler constructor.
     * @param Exception|null $ex
     * @param Request|null $request
     * @param Response|null $response
     * @param bool|null $useJson
     * @param bool|null $triggerExit
     * @param array|null $config
     */
    public function __construct(
        Exception $ex = null,
        Request $request = null,
        Response $response = null,
        ?bool $useJson = false,
        ?bool $triggerExit = true,
        array $config = null
    ) {
        parent::__construct($config);
        $this
            ->setException($ex)
            ->setRequest($request)
            ->setResponse($response)
            ->setUseJson($useJson)
            ->setTriggerExit($triggerExit);
    }
    
    /*
     * Exception logic
     */
    
    /**
     * @return Exception|ExceptionExt|null
     */
    public function getException()
    {
        return $this->ex;
    }
    
    /**
     * @param Exception|ExceptionExt|null $ex
     * @return $this
     */
    public function setException(?Exception $ex)
    {
        $this->ex = $ex;
        return $this;
    }
    
    /**
     * @param Error|null $err
     * @return $this
     */
    public function parseError(?Error $err)
    {
        $this->ex = $err !== null ?
            new ErrorExceptionExt(
                $err->getMessage(),
                $err->getCode(),
                null,
                null,
                null,
                $err->getFile(),
                $err->getLine()
            )
            : null;
        return $this;
    }
    
    /*
     * Request logic
     */
    
    /**
     * @return Request|null
     */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * @param Request|null $ex
     * @return $this
     */
    public function setRequest(?Request $request)
    {
        $this->request = $request;
        return $this;
    }
    
    /**
     * @return Request
     */
    public function createRequest(): Request
    {
        return Request::createFromGlobals();
    }
    
    /*
     * Response logic
     */
    
    /**
     * @return Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * @param Request|null $ex
     * @return $this
     */
    public function setResponse(?Response $response)
    {
        $this->response = $response;
        return $this;
    }
    
    /**
     * @return Response
     */
    public function createResponse(): Response
    {
        return new Response();
    }
    
    /*
     * JSON logic
     */
    
    /**
     * @param bool $asBool
     * @return bool|null
     */
    public function getUseJson(bool $asBool = false): ?bool
    {
        $useJson = $this->config['use_json'] ?? null;
        return $asBool ? $useJson === true : $useJson;
    }
    
    /**
     * @param bool|null $useJson
     * @return $this
     */
    public function setUseJson(?bool $useJson)
    {
        $this->config['use_json'] = $useJson;
        return $this;
    }
    
    /**
     * @return $this
     */
    public function updateUseJsonFromRequest()
    {
        $request = $this->getRequest() ?? $this->createRequest();
        return $this->setUseJson(
            $request->expectsJson()
        );
    }
    
    /*
     * Run logic
     */
    
    public function run()
    {
        $output = $this->generateLoggerOutput();
        $erCode = $this->ex->getCode();
        $request = $this->getRequest() ?? $this->createRequest();
        $response = ($this->getResponse() ?? $this->createResponse())
            ->prepare($request)
            ->setStatusCode($erCode)
            ->setContent($output)
            ->send();
        $this
            ->setRequest($request)
            ->setResponse($response);
        
        if ($this->getTriggerExit(true)) {
            exit();
        }
        
        return $this;
    }
    
    /*
     * Logger logic
     */
    
    /**
     * @return ExceptionJsonLogger|ExceptionLogger
     */
    public function returnLogger()
    {
        return $this->getUseJson(true) ?
            new ExceptionJsonLogger($this->ex)
            : new ExceptionLogger($this->ex);
    }
    
    /**
     * @return string
     * @throws Exception
     */
    public function generateLoggerOutput(): string
    {
        return $this
            ->returnLogger()
            ->run()
            ->getOutput() ?? '';
    }
}