<?php


namespace Twinkl\User\Crud;


use Twinkl\Core\Crud\BaseCrud;
use Twinkl\Core\Glob\SessionGlob;
use Twinkl\Eloquent\Model\User\User;

/**
 * Class UserDeleter
 * @package Twinkl\User\Crud
 */
class UserDeleter extends BaseCrud
{
    /**
     * @param int[] $deleteUserIds
     * @return $this
     */
    public function deleteAllByIds(array $deleteUserIds)
    {
        if (($deleteUserIds = array_filter($deleteUserIds))) {
            $this->useSessAsDb() ?
                $this->processDeleteAllByIdsFromSess($deleteUserIds)
                : $this->processDeleteAllByIdsFromDb($deleteUserIds);
        }
        return $this;
    }
    
    /**
     * @param array $userIds
     * @return void
     */
    protected function processDeleteAllByIdsFromDb(array $userIds): void
    {
        User::whereIn('id', $userIds)->delete();
    }
    
    /**
     * @param array $userIds
     * @return void
     */
    protected function processDeleteAllByIdsFromSess(array $userIds): void
    {
        $users = $this->excludeUsersById($userIds);
        (new SessionGlob())->setUsers($users);
    }
    
    /**
     * @param int[] $excludeUserIds
     * @return array
     */
    protected function excludeUsersById(array $excludeUserIds)
    {
        $excludeUserIdsFlip = array_flip($excludeUserIds);
        return array_filter(
            (new SessionGlob())->getUsers(),
            static function ($iUser) use (&$excludeUserIdsFlip) {
                return !isset($excludeUserIdsFlip[$iUser['id']]);
            }
        );
    }
}