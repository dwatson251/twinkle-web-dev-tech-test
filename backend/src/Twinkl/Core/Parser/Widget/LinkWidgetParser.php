<?php


namespace Twinkl\Core\Parser\Widget;

use Twinkl\Core\Widget\Link\LinkWidget;

/**
 * Class LinkWidgetParser
 * @package Twinkl\Core\Parser\Widget
 */
class LinkWidgetParser extends WidgetParser
{
    /*
     * Properties
     */
    
    protected $widgetClass = LinkWidget::class;
    
    /*
     * Parse logic
     */
    
    protected function returnArrayInstanceArgs($value): array
    {
        return [null, null, null, $value];
    }
}
