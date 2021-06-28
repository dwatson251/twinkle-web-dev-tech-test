<?php


namespace Twinkl\Dashboard\Model;


use Exception;
use LogicException;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Glob\SessionGlob;
use Twinkl\Core\Helper\ArrayExt\ArrayHelper;
use Twinkl\User\Crud\UserCreator;
use Twinkl\User\Crud\UserDeleter;
use Twinkl\User\Crud\UserReader;

/**
 * Class DashboardUserModel
 * @package Twinkl\Dashboard\Model
 */
class DashboardUserModel
{
    /**
     * @var UserCreator|null
     */
    protected $userCreator;
    /**
     * @var UserReader|null
     */
    protected $userReader;
    /**
     * @var UserDeleter|null
     */
    protected $userDeleter;
    /**
     * @var array
     */
    protected $users = [];
    /**
     * @var int[]
     */
    protected $userIds = [];
    
    /*
     * Init logic
     */
    
    /**
     * @return UserCreator
     */
    protected function getUserCreator(): UserCreator
    {
        $this->userCreator = $this->userCreator ?? new UserCreator();
        return $this->userCreator;
    }
    
    /**
     * @return UserReader
     */
    protected function getUserReader(): UserReader
    {
        return $this->userReader;
    }
    
    /**
     * @return UserReader
     */
    protected function getUserDeleter(): UserDeleter
    {
        $this->userDeleter = $this->userDeleter ?? new UserDeleter();
        return $this->userDeleter;
    }
    
    /**
     * @return array
     */
    public function getUsers(): array
    {
        return $this->users;
    }
    
    /**
     * @param array $users
     * @return $this
     */
    public function setUsers(array $users)
    {
        $this->users = $users;
        return $this;
    }
    
    /**
     * @return int[]
     */
    public function getUserIds(): array
    {
        return $this->users;
    }
    
    /**
     * @param int[] $userIds
     * @return $this
     */
    public function setUserIds(array $userIds)
    {
        $this->users = $userIds;
        return $this;
    }
    
    /**
     * @return $this
     */
    public function loadAllUsers()
    {
        $this->users = array_merge(
            $this->user,
            $this
                ->getUserReader()
                ->getAll()
        );
        return $this;
    }
    
    /**
     * @return $this
     */
    public function loadUser(int $userId)
    {
        $user = $this
            ->getUserReader()
            ->getById($userId);
        if (!$user) {
            throw new LogicException("User: #{$userId} not found!", HttpConsts::CODE_NOT_FOUND);
        }
        $this->users[] = $userId;
        return $this;
    }
    
    /**
     * @param array $users
     * @return $this
     * @throws Exception
     */
    public function saveUsers(array $users)
    {
        $userIds = $this
            ->getUserCreator()
            ->createAll($users);
        $users = $this
            ->getUserReader()
            ->getAllById($userIds);
        array_push($this->userIds, ...$userIds);
        array_push($this->users, ...$users);
        return $this;
    }
    
    /**
     * @param int[] $userIds
     * @return $this
     */
    public function deleteUsers(array $userIds)
    {
        $this
            ->getUserDeleter()
            ->deleteAllByIds($userIds);
        return $this;
    }
}
