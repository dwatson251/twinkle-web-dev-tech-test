<?php


namespace Twinkl\Core\Widget\Stylesheet;


use Twinkl\Core\Widget\BaseWidget;
use Twinkl\Core\Widget\CustomTrait\ContentWidgetTrait;

/**
 * Class StyleWidget
 * @package Twinkl\Core\Widget\Stylesheet
 */
class StyleWidget extends BaseWidget
{
    /*
     * Traits
     */
    
    use ContentWidgetTrait;
    
    /*
     * Init logic
     */
    
    /**
     * ScriptWidget constructor.
     * @param string|null $href
     * @param string|null $rel
     * @param string|null $content
     * @param string|null $templateName
     * @param array|null $attrs
     * @param array|null $config
     */
    public function __construct(
        string $href = null,
        string $rel = null,
        string $content = null,
        string $templateName = null,
        array $attrs = null,
        array $config = null
    ) {
        parent::__construct($templateName, $attrs, $config);
        $this
            ->setSrc($href ?? ($attrs['src'] ?? null))
            ->setType($rel ?? ($attrs['type'] ?? null))
            ->setContent($content);
    }
    
    /*
     * Source logic
     */
    
    /**
     * @return string|null
     */
    public function getSrc(): ?string
    {
        return $this->attrs['src'] ?? null;
    }
    
    /**
     * @param string|null $src
     * @return $this
     */
    public function setSrc(?string $src)
    {
        $this->attrs['src'] = $src;
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->attrs['type'] ?? null;
    }
    
    /**
     * @param string|null $type
     * @return $this
     */
    public function setType(?string $type)
    {
        $this->type = $type;
        return $this;
    }
    
    
    /*
     * Content logic
     */
    
    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }
    
    /**
     * @param string|null $content
     * @return $this
     */
    public function setContent(?string $content)
    {
        $this->content = $content;
        return $this;
    }
}
