<?php


namespace Twinkl\Core\Widget\Text;


use Twinkl\Core\Widget\BaseWidget;
use Twinkl\Core\Widget\CustomTrait\ContentWidgetTrait;

/**
 * Class TextWidget
 * @package Twinkl\Core\Widget\Text
 */
class TextWidget extends BaseWidget
{
    /*
     * Traits
     */
    
    use ContentWidgetTrait;
    
    /**
     * TextWidget constructor.
     * @param mixed|null $content
     * @param string|null $templateName
     * @param array|null $attrs
     * @param array|null $config
     */
    public function __construct(
        $content = null,
        string $templateName = null,
        array $attrs = null,
        array $config = null
    ) {
        parent::__construct($templateName, $attrs, $config);
        $this->setContent($content);
    }
}
