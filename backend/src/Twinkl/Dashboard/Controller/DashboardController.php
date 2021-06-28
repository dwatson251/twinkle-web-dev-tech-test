<?php

namespace Twinkl\Dashboard\Controller;

use Illuminate\Http\Response;
use Twinkl\Core\Consts\TemplateConsts;
use Twinkl\Core\Controller\RootController;
use Twinkl\Dashboard\Model\DashboardUserModel;
use Twinkl\Dashboard\Widget\Builder\DashboardWidgetBuilder;

/**
 * Class DashboardController
 * @package Twinkl\Dashboard\Controller
 */
class DashboardController extends RootController
{
    /*
     * Properties
     */
    
    /**
     * @var DashboardUserModel|null
     */
    protected $dashUserModel;
    /**
     * @var DashboardWidgetBuilder|null
     */
    protected $dashWidgetBuilder;
    
    public function __construct()
    {
        parent::__construct();
        $this->dashUserModel = new DashboardUserModel();
    }
    
    /*
     * Routing logic
     */
    
    /**
     * @return Response
     */
    public function index()
    {
        $users = $this->dashUserModel
            ->loadAllusers()
            ->getUsers();
        return $this->createResponse(
            $this->renderIndex($users)
        );
    }
    
    /*
     * Render logic
     */
    
    protected function renderIndex(array $users)
    {
        $this->buildDashboardWidget($users);
        return $this->render(
            TemplateConsts::FLD_DASH . '::index',
            ['widget' => $this->dashWidgetBuilder->getDashboardWidget()]
        );
    }
    
    /*
     * Widget logic
     */
    
    /**
     * @param array|null $users
     * @return $this
     */
    protected function buildDashboardWidget(array $users = null)
    {
        $this->dashWidgetBuilder = (new DashboardWidgetBuilder($users))->build();
        return $this;
    }
}
