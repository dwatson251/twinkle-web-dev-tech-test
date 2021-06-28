<?php


namespace Twinkl\Dashboard\Widget;

use Twinkl\Core\Consts\ImgConsts;
use Twinkl\Core\Widget\Body\BodyWidget;
use Twinkl\Core\Widget\Head\HeadWidget;
use Twinkl\Core\Widget\Layout\LayoutWidget;
use Twinkl\Dashboard\Widget\User\DashboardUserAddWidget;
use Twinkl\Dashboard\Widget\User\DashboardUserEditWidget;

/**
 * Class DashboardWidget
 * @package Twinkl\Widget\Dashboard
 */
class DashboardWidget extends LayoutWidget
{
    /*
     * Properties
     */
    
    /**
     * @var DashboardUserEditWidget[]|DashboardUserAddWidget[]
     */
    protected $userWidgets = [];
    /**
     * @var string|null
     */
    protected $twinklLogo = ImgConsts::SRC_TWNKL_LOGO;
    
    /*
     * Init logic
     */
    
    /**
     * DashboardWidget constructor.
     * @param DashboardUserEditWidget[]|DashboardUserAddWidget[]|null $userWidgets
     * @param string|null $twinklLogo
     * @param BodyWidget|null $body
     * @param HeadWidget|null $head
     * @param string|null $templateName
     * @param array|null $attrs
     * @param array|null $config
     */
    public function __construct(
        array $userWidgets = null,
        string $twinklLogo = null,
        BodyWidget $body = null,
        HeadWidget $head = null,
        string $templateName = null,
        array $attrs = null,
        array $config = null
    ) {
        parent::__construct($body, $head, $templateName, $attrs, $config);
        $this
            ->setUserWidgets($userWidgets)
            ->setTwinklLogo($twinklLogo ?? $this->twinklLogo);
    }
    
    /*
     * Users logic
     */
    
    /**
     * @return DashboardUserEditWidget[]|DashboardUserAddWidget[]
     */
    public function getUserWidgets()
    {
        return $this->userWidgets;
    }
    
    /**
     * @param DashboardUserEditWidget[]|DashboardUserAddWidget[]|null $userWidgets
     * @return $this
     */
    public function setUserWidgets(?array $userWidgets)
    {
        $this->userWidgets = $userWidgets ?? [];
        return $this;
    }
    
    /*
     * Logo logic
     */
    
    /**
     * @return string|null
     */
    public function getTwinklLogo(): ?string
    {
        return $this->twinklLogo;
    }
    
    /**
     * @param string|null $twinklLogo
     * @return $this
     */
    public function setTwinklLogo(?string $twinklLogo)
    {
        $this->twinklLogo = $twinklLogo;
        return $this;
    }
}
