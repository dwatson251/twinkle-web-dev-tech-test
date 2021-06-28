<?php


namespace Twinkl\Core\Widget\Link;

use Twinkl\Core\Consts\CssConsts;
use Twinkl\Core\Consts\HtmlConsts;

/**
 * Class CssLinkWidget
 * @package Twinkl\Core\Widget\Link
 */
class CssLinkWidget extends LinkWidget
{
    /*
     * Init logic
     */
    
    public function __construct(
        string $href = null,
        string $templateName = null,
        array $attrs = null,
        array $config = null
    ) {
        parent::__construct(
            $href,
            HtmlConsts::LINK_REL_CSS,
            $templateName,
            $attrs,
            $config
        );
    }
    
    /*
     * Rel logic
     */
    
    public function getRel(): ?string
    {
        return HtmlConsts::LINK_REL_CSS;
    }
    
    public function setRel(?string $rel)
    {
        return parent::setRel(HtmlConsts::LINK_REL_CSS);
    }
}
