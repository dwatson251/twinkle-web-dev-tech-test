<?php


namespace Twinkl\Core\Widget\Link;


use Twinkl\Core\Consts\CssConsts;
use Twinkl\Core\Widget\BaseWidget;

/**
 * Class LinkWidget
 * @package Twinkl\Core\Widget\Link
 */
class LinkWidget extends BaseWidget
{
    /*
     * Init logic
     */
    
    /**
     * ScriptWidget constructor.
     * @param string|null $href
     * @param string|null $rel
     * @param string|null $templateName
     * @param array|null $attrs
     * @param array|null $config
     */
    public function __construct(
        string $href = null,
        string $rel = null,
        string $templateName = null,
        array $attrs = null,
        array $config = null
    ) {
        parent::__construct($templateName, $attrs, $config);
        $this
            ->setHref($href ?? ($attrs['href'] ?? null))
            ->setRel($rel ?? ($attrs['rel'] ?? null));
    }
    
    /*
     * Source logic
     */
    
    /**
     * @return string|null
     */
    public function getHref(): ?string
    {
        return $this->attrs['href'] ?? null;
    }
    
    /**
     * @param string|null $href
     * @return $this
     */
    public function setHref(?string $href)
    {
        $this->attrs['href'] = $href;
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getRel(): ?string
    {
        return $this->attrs['rel'] ?? null;
    }
    
    /**
     * @param string|null $rel
     * @return $this
     */
    public function setRel(?string $rel)
    {
        $this->attrs['rel'] = $rel;
        return $this;
    }
}
