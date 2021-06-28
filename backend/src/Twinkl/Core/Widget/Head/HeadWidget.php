<?php


namespace Twinkl\Core\Widget\Head;


use Twinkl\Core\Util\PageUtils;
use Twinkl\Core\Widget\BaseWidget;
use Twinkl\Core\Widget\CustomTrait\LinksTrait;
use Twinkl\Core\Widget\CustomTrait\ParentWidgetTrait;
use Twinkl\Core\Widget\CustomTrait\ScriptsTrait;
use Twinkl\Core\Widget\Script\ScriptWidget;
use Twinkl\Core\Widget\Text\TextWidget;

/**
 * Class HeadWidget
 * @package Twinkl\Core\Widget\Head
 */
class HeadWidget extends BaseWidget
{
    /*
     * Traits
     */
    
    use ParentWidgetTrait, ScriptsTrait, LinksTrait;
    
    /*
     * Properties
     */
    
    /**
     * @var TextWidget|null
     */
    protected $title;
    
    /*
     * Init logic
     */
    
    /**
     * HeadWidget constructor.
     * @param array|null $children
     * @param TextWidget|null $title
     * @param ScriptWidget[]|null $scripts
     * @param string|null $templateName
     * @param array|null $attrs
     * @param array|null $config
     */
    public function __construct(
        array $children = null,
        TextWidget $title = null,
        array $scripts = null,
        string $templateName = null,
        array $attrs = null,
        array $config = null
    ) {
        parent::__construct($templateName, $attrs, $config);
        $this
            ->setChildren($children)
            ->setTitle($title)
            ->setScripts($scripts);
    }
    
    /*
     * Title logic
     */
    
    /**
     * @return TextWidget|null
     */
    public function getTitle(): ?TextWidget
    {
        return $this->title;
    }
    
    /**
     * @param TextWidget|null $title
     * @return $this
     */
    public function setTitle(?TextWidget $title)
    {
        $this->title = $title;
        return $this;
    }
    
    /*
     * Scripts logic
     */
    
    public function returnScripts(): array
    {
        return array_merge(
            PageUtils::getInstance()->getHeaderScripts(),
            $this->scripts
        );
    }
    
    /*
     * Links logic
     */
    
    public function returnLinks(): array
    {
        return array_merge(
            PageUtils::getInstance()->getHeaderLinks(),
            $this->links
        );
    }
}
