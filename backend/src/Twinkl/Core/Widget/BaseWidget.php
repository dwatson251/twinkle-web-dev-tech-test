<?php


namespace Twinkl\Core\Widget;


use Twinkl\Core\Exception\ParseException;
use Twinkl\Core\Helper\Debug\VarDumpDebugHelper;
use Twinkl\Core\Parser\Html\HtmlAttributesToStringParser;

/**
 * Class BaseWidget
 * @package Twinkl\Widget
 */
class BaseWidget
{
    /*
     * Properties
     */
    
    /**
     * @var string|null
     */
    protected $templateName;
    /**
     * @var array
     */
    protected $attrs = [];
    /**
     * @var array
     */
    protected $config = [];
    /**
     * @var mixed|null
     */
    protected $debug;
    
    /**
     * BaseWidget constructor.
     * @param string|null $templateName
     * @param array|null $attrs
     * @param array|null $config
     */
    public function __construct(
        string $templateName = null,
        array $attrs = null,
        array $config = null
    ) {
        $this
            ->setTemplateName($templateName)
            ->setAttrs($attrs)
            ->setConfig($config);
    }
    
    /*
     * Template name logic
     */
    
    /**
     * @return string|null
     */
    public function getTemplateName(): ?string
    {
        return $this->templateName;
    }
    
    /**
     * @param string|null $templateName
     * @return $this
     */
    public function setTemplateName(?string $templateName)
    {
        $this->templateName = $templateName;
        return $this;
    }
    
    /*
     * Attrs logic
     */
    
    /**
     * @return array
     */
    public function getAttrs(): array
    {
        return $this->attrs;
    }
    
    /**
     * @param array|null $attrs
     * @return $this
     */
    public function setAttrs(?array $attrs)
    {
        $this->attrs = $attrs ?? [];
        return $this;
    }
    
    /**
     * @return string
     * @throws ParseException
     */
    public function renderAttrs(): string
    {
        $htmlAttrParser = new HtmlAttributesToStringParser($this->getAttrs());
        return $htmlAttrParser
            ->parse()
            ->getValue();
    }
    
    /*
     * Config logic
     */
    
    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }
    
    /**
     * @param array|null $config
     * @return $this
     */
    public function setConfig(?array $config)
    {
        $this->config = $config ?? [];
        return $this;
    }
    
    /*
     * Debug logic
     */
    
    /**
     * @return bool
     */
    public function showDebug(): bool
    {
        return (bool) ($this->config['show_debug'] ?? false);
    }
    
    /**
     * @return string
     */
    public function renderDebug(): string
    {
        return !$this->showDebug() ?
            ''
            : (new VarDumpDebugHelper($this->debug))->dump();
    }
}
