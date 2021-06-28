<?php


namespace Twinkl\Core\Parser\Widget;

use Exception;
use LogicException;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Exception\ExceptionExt;
use Twinkl\Core\Exception\ParseException;
use Twinkl\Core\Helper\ClassExt\ReflectionClassHelper;
use Twinkl\Core\Helper\EvalExt\EvalHelper;
use Twinkl\Core\Parser\BaseParser;
use Twinkl\Core\Widget\BaseWidget;

class WidgetParser extends BaseParser
{
    /**
     * @var string|null
     */
    protected $widgetClass;
    
    /*
     * Widget class logic
     */
    
    /**
     * @return string|null
     */
    public function getWidgetClass(): ?string
    {
        return $this->widgetClass;
    }
    
    /**
     * @param string|null $widgetClass
     * @return $this
     */
    public function setWidgetClass($widgetClass)
    {
        $this->widgetClass = $widgetClass;
        return $this;
    }
    
    /*
     * Parse logic
     */
    
    public function parse()
    {
        try {
            $this->reset();
            $this->value = $this->processParse($this->value);
            return $this;
        } catch (Exception $ex) {
            $prop = $this->prop ?? 'widget';
            $this->ex = new ParseException(
                "Unable to parse {$prop}.",
                HttpConsts::CODE_SERVER_ERROR,
                "{$prop} is not null / string / array " . BaseWidget::class . ".",
                'null / string / array ' . BaseWidget::class . '.',
                $this->value,
                $prop,
                $this->context
            );
            throw $this->ex;
        }
    }
    
    /**
     * @param mixed $value
     * @return BaseWidget|null
     * @throws Exception
     */
    protected function processParse($value): ?BaseWidget
    {
        if (!$value) {
            return $this->defValue;
        }
        
        if (!$this->widgetClass) {
            throw new LogicException('Widget class is not defined.', HttpConsts::CODE_SERVER_ERROR);
        }
        
        if ($value instanceof $this->widgetClass) {
            return $value;
        }
        
        if ((new EvalHelper($value))->isNonBoolScalar()) {
            return $this->parseNoBoolScalar($value);
        }
        
        if (is_array($value)) {
            return $this->parseArray($value);
        }
        
        throw new ExceptionExt(
            'Invalid widget.',
            HttpConsts::CODE_SERVER_ERROR,
            'Value type is not compatible.',
            "null / string / array / {$this->widgetClass}."
        );
    }
    
    /**
     * @param mixed $value
     * @return BaseWidget
     * @throws Exception
     */
    protected function parseNoBoolScalar($value): BaseWidget
    {
        return $this->returnWidgetClassHelperInstance(
            $this->returnStringInstanceArgs($value)
        );
    }
    
    /**
     * @param mixed $value
     * @return BaseWidget
     * @throws Exception
     */
    protected function parseArray($value): BaseWidget
    {
        return $this->returnWidgetClassHelperInstance(
            $this->returnArrayInstanceArgs($value)
        );
    }
    
    /**
     * @param array|null $classArgs
     * @return BaseWidget
     * @throws Exception
     */
    protected function returnWidgetClassHelperInstance(array $classArgs = null): BaseWidget
    {
        return (new ReflectionClassHelper($this->widgetClass, $classArgs))
            ->build()
            ->getInstance();
    }
    
    /**
     * @param mixed $value
     * @return array
     */
    protected function returnStringInstanceArgs($value): array
    {
        return [$value];
    }
    
    /**
     * @param mixed $value
     * @return array
     */
    protected function returnArrayInstanceArgs($value): array
    {
        return [$value];
    }
}
