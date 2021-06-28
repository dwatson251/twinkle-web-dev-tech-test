<?php


namespace Twinkl\Dashboard\Widget\Builder;


use Exception;
use Twinkl\Core\Exception\ExceptionExt;
use Twinkl\Core\Widget\Builder\BaseWidgetBuilder;
use Twinkl\Dashboard\Widget\DashboardWidget;
use Twinkl\Dashboard\Widget\User\DashboardUserCreateWidget;
use Twinkl\Dashboard\Widget\User\DashboardUserEditWidget;
use Twinkl\Dashboard\Widget\User\DashboardUserAddWidget;

/**
 * Class DashboardIndexWidgetBuilder
 * @package Twinkl\Dashboard\Widget\Builder
 */
class DashboardWidgetBuilder extends BaseWidgetBuilder
{
    /**
     * @var DashboardWidget|null
     */
    protected $dashWidget;
    /**
     * @var DashboardUserAddWidget[]|DashboardUserEditWidget[]
     */
    protected $userWidgets = [];
    /**
     * @var array
     */
    protected $users = [];
    
    /*
     * Init logic
     */
    
    /**
     * DashboardIndexWidgetBuilder constructor.
     * @param array|null $users
     * @param array|null $config
     */
    public function __construct(array $users = null, array $config = null)
    {
        parent::__construct($config);
        $this->setUsers($users);
    }
    
    /*
     * Users logic
     */
    
    /**
     * @return array
     */
    public function getUsers(): array
    {
        return $this->users;
    }
    
    /**
     * @param array|null $users
     * @return $this
     */
    public function setUsers(?array $users)
    {
        $this->users = $users ?? [];
        return $this;
    }
    
    /*
     * Dashboard widget logic
     */
    
    /**
     * @return DashboardWidget|null
     */
    public function getDashboardWidget(): ?DashboardWidget
    {
        return $this->dashWidget;
    }
    
    /**
     * @param DashboardWidget|null $dashboardWidget
     * @return $this
     */
    public function setDashboardWidget($dashboardWidget)
    {
        $this->dashWidget = $dashboardWidget;
        return $this;
    }
    
    /**
     * @return $this
     */
    public function buildDashboardWidget()
    {
        $this->dashWidget = new DashboardWidget($this->userWidgets);
        return $this;
    }
    
    /*
     * User widget logic
     */
    
    /**
     * @return DashboardUserEditWidget[]|DashboardUserAddWidget[]
     */
    public function getUserWidgets(): array
    {
        return $this->userWidgets;
    }
    
    /**
     * @param DashboardUserEditWidget[]|DashboardUserAddWidget[] $userWidgets
     * @return $this
     */
    public function setUserWidgets(?array $userWidgets)
    {
        $this->userWidgets = $userWidgets ?? [];
        return $this;
    }
    
    /**
     * @return $this
     */
    public function buildUserWidgets()
    {
        $this->userWidgets = array_reduce(
            $this->users,
            function ($carry, $iUser) {
                if ($iUser) {
                    $carry[] = $this->createUserEditWidget($iUser);
                }
                return $carry;
            },
            []
        );
        $this->userWidgets[] = $this->createUserAddWidget();
        return $this;
    }
    
    /**
     * @param array|null $user
     * @return DashboardUserEditWidget
     */
    public function createUserEditWidget(array $user = null)
    {
        return new DashboardUserEditWidget($user);
    }
    
    /**
     * @return DashboardUserAddWidget
     */
    public function createUserAddWidget()
    {
        return new DashboardUserAddWidget();
    }
    
    /**
     * @return DashboardUserCreateWidget
     */
    public function createUserCreateWidget()
    {
        return new DashboardUserCreateWidget();
    }
    
    /*
     * Build
     */
    
    /**
     * @return $this
     * @throws Exception
     */
    public function build()
    {
        try {
            return $this
                ->buildUserWidgets()
                ->buildDashboardWidget();
        } catch (Exception $ex) {
            throw new ExceptionExt(
                'Unable to build dashboard index widgets.',
                $ex->getCode(),
                $ex->getMessage(),
                null,
                $ex
            );
        }
    }
}
