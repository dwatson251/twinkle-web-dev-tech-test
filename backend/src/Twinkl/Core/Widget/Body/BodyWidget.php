<?php


namespace Twinkl\Core\Widget\Body;


use Twinkl\Core\Util\PageUtils;
use Twinkl\Core\Widget\BaseWidget;
use Twinkl\Core\Widget\CustomTrait\ParentWidgetTrait;
use Twinkl\Core\Widget\CustomTrait\ScriptsTrait;
use Twinkl\Core\Widget\Script\ScriptWidget;
use Twinkl\Core\Widget\Text\TextWidget;

/**
 * Class BodyWidget
 * @package Twinkl\Core\Widget\Body
 */
class BodyWidget extends BaseWidget
{
    /*
     * Traits
     */
    
    use ParentWidgetTrait, ScriptsTrait;
    
    /*
     * Properties
     */
    
    /**
     * @var TextWidget|null
     */
    protected $h1;
    
    /*
     * Init logic
     */
    
    /**
     * BodyWidget constructor.
     * @param array|null $children
     * @param \Twinkl\Core\Widget\Text\TextWidget|null $h1
     * @param ScriptWidget[]|null $scripts
     * @param string|null $templateName
     * @param array|null $attrs
     * @param array|null $config
     */
    public function __construct(
        array $children = null,
        TextWidget $h1 = null,
        array $scripts = null,
        string $templateName = null,
        array $attrs = null,
        array $config = null
    ) {
        parent::__construct($templateName, $attrs, $config);
        $this
            ->setChildren($children)
            ->setH1($h1)
            ->setScripts($scripts);
    }
    
    /*
     * H1 logic
     */
    
    /**
     * @return TextWidget|null
     */
    public function getH1(): ?TextWidget
    {
        return $this->h1;
    }
    
    /**
     * @param TextWidget|null $h1
     * @return $this
     */
    public function setH1(?TextWidget $h1)
    {
        $this->h1 = $h1;
        return $this;
    }
    
    /*
     * Scripts logic
     */
    
    public function returnScripts(): array
    {
        return array_merge(
            PageUtils::getInstance()->getFooterScripts(),
            $this->scripts
        );
    }
}
