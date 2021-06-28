<?php

namespace Twinkl\Dashboard\Controller;

use Exception;
use Illuminate\Http\Response;
use InvalidArgumentException;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Consts\TemplateConsts;
use Twinkl\Core\Controller\RootController;
use Twinkl\Dashboard\Model\DashboardUserModel;
use Twinkl\Dashboard\Widget\Builder\DashboardWidgetBuilder;

class DashboardUserController extends RootController
{
    /**
     * @var DashboardUserModel|null
     */
    protected $dashUserModel;
    /**
     * @var DashboardWidgetBuilder|null
     */
    protected $dashWidgetBuilder;
    
    public function index()
    {
        return $this->createResponse('get index');
    }
    
    /**
     * @return Response
     */
    public function create()
    {
        try {
            $content = $this->renderUserCreateWidget();
            return $this->createResponse($content);
        } catch (Exception $ex) {
            return $this->createResponse(
                'Unable to render dash user create widget.',
                $ex->getCode()
            );
        }
    }
    
    public function store()
    {
        try {
            $newUser = $this->request->all();
            $newUser = $this
                ->getDashboardUserModel()
                ->saveUsers([$newUser])
                ->getUsers()[0];
            return $this->createResponse(
                $this->renderUserEditWidget($newUser)
            );
        } catch (Exception $ex) {
            return $this->createResponse(
                'Unable to create new user.',
                $ex->getCode()
            );
        }
    }
    
    public function update(int $userId)
    {
        try {
            $newUser = $this
                ->getDashboardUserModel()
                ->saveUsers(
                    [$this->request->all()]
                )[0];
            return $this->createResponse(['user_id' => $newUser['id']]);
        } catch (Exception $ex) {
            return $this->createResponse(
                'Unable to update user.',
                $ex->getCode()
            );
        }
    }
    
    /**
     * @param int $userId
     * @return Response
     */
    public function destroy(int $userId)
    {
        try {
            if (!$userId) {
                throw new InvalidArgumentException('Invalid user ID.', HttpConsts::CODE_INVALID_REQUEST);
            }
            $this
                ->getDashboardUserModel()
                ->deleteUsers([$userId]);
            return $this->createResponse(['message' => "Successfully deleted user: #{$userId}"]);
        } catch (Exception $ex) {
            return $this->createResponse(
                'Unable to delete user.',
                $ex->getCode()
            );
        }
    }
    
    /*
     * Model logic
     */
    
    /**
     * @return DashboardUserModel
     */
    protected function getDashboardUserModel()
    {
        $this->dashUserModel = $this->dashUserModel ?? new DashboardUserModel();
        return $this->dashUserModel;
    }
    
    /*
     * Render logic
     */
    
    /**
     * @return string
     */
    protected function renderUserCreateWidget()
    {
        $userCreateWidget = $this
            ->getDashboardWidgetBuilder()
            ->createUserCreateWidget();
        return $this->render(
            TemplateConsts::FLD_DASH . '::partial/user-create',
            ['widget' => $userCreateWidget]
        );
    }
    
    /**
     * @return string
     */
    protected function renderUserEditWidget(array $user)
    {
        $userEditWidget = $this
            ->getDashboardWidgetBuilder()
            ->createUserEditWidget($user);
        return $this->render(
            TemplateConsts::FLD_DASH . '::partial/user-edit',
            ['widget' => $userEditWidget]
        );
    }
    
    /*
     * Widget logic
     */
    
    /**
     * @return DashboardWidgetBuilder|null
     */
    protected function getDashboardWidgetBuilder()
    {
        $this->dashWidgetBuilder = $this->dashWidgetBuilder ?? new DashboardWidgetBuilder();
        return $this->dashWidgetBuilder;
    }
}
