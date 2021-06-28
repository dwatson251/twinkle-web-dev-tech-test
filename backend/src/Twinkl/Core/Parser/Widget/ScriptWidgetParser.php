<?php


namespace Twinkl\Core\Parser\Widget;

use Twinkl\Core\Widget\Script\ScriptWidget;

/**
 * Class ScriptWidgetParser
 * @package Twinkl\Core\Parser\Widget
 */
class ScriptWidgetParser extends WidgetParser
{
    /*
     * Properties
     */
    
    protected $widgetClass = ScriptWidget::class;
    
    /*
     * Parse logic
     */
    
    protected function returnArrayInstanceArgs($value): array
    {
        return [null, null, null, null, $value];
    }
}
