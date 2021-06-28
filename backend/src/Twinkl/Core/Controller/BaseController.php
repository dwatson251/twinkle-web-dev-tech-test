<?php

namespace Twinkl\Core\Controller;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use LogicException;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\TemplateBuilder\BaseTemplateBuilder;

/**
 * Class BaseController
 * @package Twinkl\Core\Controller
 */
abstract class BaseController extends Controller
{
    /*
     * Properties
     */
    
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var BaseTemplateBuilder
     */
    protected $templateBuilder;
    
    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->request = Request::createFromGlobals();
        $this->buildTemplateBuilder();
    }
    
    /*
     * Response logic
     */
    
    /**
     * @param mixed|null $content
     * @param null|int $code
     * @param null|array $headers
     * @param bool $triggerPrepare
     * @return Response
     */
    protected function createResponse(
        $content = null,
        int $code = null,
        array $headers = null,
        bool $triggerPrepare = true
    ) {
        $response = new Response(
            $content ?? '',
            $code ?? HttpConsts::CODE_SUCCESS,
            $headers ?? []
        );
        if ($triggerPrepare) {
            $response->prepare($this->request);
        }
        return $response;
    }
    
    /*
     * Template builder logic
     */
    
    /**
     * @return $this
     */
    abstract protected function buildTemplateBuilder();
    
    /**
     * @param bool $triggerEx
     * @return bool
     * @throws Exception
     */
    protected function checkIssetTemplateBuilder(bool $triggerEx = true): bool
    {
        if (!$this->templateBuilder) {
            if ($triggerEx) {
                throw new LogicException(
                    'Template builder instance is not defined!',
                    HttpConsts::CODE_SERVER_ERROR
                );
            }
            return false;
        }
        return true;
    }
    
    /*
     * Render logic
     */
    
    /**
     * @return string
     */
    abstract public function render(): string;
}
