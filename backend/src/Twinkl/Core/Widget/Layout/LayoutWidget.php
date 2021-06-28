<?php


namespace Twinkl\Core\Widget\Layout;


use Twinkl\Core\Widget\BaseWidget;
use Twinkl\Core\Widget\Body\BodyWidget;
use Twinkl\Core\Widget\Head\HeadWidget;

/**
 * Class LayoutWidget
 * @package Twinkl\Core\Widget\Layout
 */
class LayoutWidget extends BaseWidget
{
    /*
     * Properties
     */
    
    /**
     * @var HeadWidget|null
     */
    protected $head;
    /**
     * @var BodyWidget|null
     */
    protected $body;
    
    /*
     * Init logic
     */
    
    /**
     * LayoutWidget constructor.
     * @param BodyWidget|null $body
     * @param HeadWidget|null $head
     * @param string|null $templateName
     * @param array|null $attrs
     * @param array|null $config
     */
    public function __construct(
        BodyWidget $body = null,
        HeadWidget $head = null,
        string $templateName = null,
        array $attrs = null,
        array $config = null
    ) {
        parent::__construct($templateName, $attrs, $config);
        $this
            ->setHead($head)
            ->setBody($body);
    }
    
    /*
     * Head logic
     */
    
    /**
     * @return HeadWidget|null
     */
    public function getHead(): ?HeadWidget
    {
        return $this->head;
    }
    
    /**
     * @param HeadWidget|null $head
     * @return $this
     */
    public function setHead(?HeadWidget $head)
    {
        $this->head = $head;
        return $this;
    }
    
    /*
     * Body logic
     */
    
    /**
     * @return BodyWidget|null
     */
    public function getBody(): ?BodyWidget
    {
        return $this->body;
    }
    
    /**
     * @param BodyWidget|null $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }
}
