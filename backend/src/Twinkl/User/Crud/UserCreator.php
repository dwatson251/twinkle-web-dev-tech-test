<?php


namespace Twinkl\User\Crud;


use Exception;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Crud\BaseCrud;
use Twinkl\Core\Glob\SessionGlob;
use Twinkl\Core\Parser\Entity\EntityParser;
use Twinkl\Eloquent\Model\User\User;
use Twinkl\User\Entity\UserEntity;

/**
 * Class UserCreater
 * @package Twinkl\User\Crud
 */
class UserCreator extends BaseCrud
{
    /**
     * @var int|null
     */
    protected $lastId;
    
    
    /**
     * @param array $users
     * @return array
     * @throws Exception
     */
    public function createAll(array $users)
    {
        if (!array_filter($users)) {
            throw new \LogicException('Users are not defined.', HttpConsts::CODE_SERVER_ERROR);
        }
        return $this->useSessAsDb() ?
            $this->processCreateAllUsingSess($users)
            : $this->processCreateAllUsingDb($users);
    }
    
    /**
     * @param array $users
     * @return array
     * @throws Exception
     */
    protected function processCreateAllUsingDb($users)
    {
        $userDb = new User();
        $userDb->insert($users);
        return $userDb->returnLastInsertIds(null, count($users));
    }
    
    /**
     * @param array $users
     * @return int[]
     * @throws Exception
     */
    protected function processCreateAllUsingSess($users)
    {
        $sess = new SessionGlob();
        $currUsers = $sess->getUsers();
        $newUsers = $this->sanitiseCreateUsers($users);
        $sess->setUsers(
            array_merge($currUsers, $newUsers)
        );
        return array_column($newUsers, 'id');
    }
    
    /**
     * @param array $users
     * @return array
     * @throws Exception
     */
    protected function sanitiseCreateUsers(array $users)
    {
        $entParser = (new EntityParser(null, null, UserEntity::class))
            ->setTriggerClean(true);
        return array_reduce(
            $users,
            function ($carry, $iUser) use (&$entParser) {
                $iUser = $entParser
                    ->setValue($iUser)
                    ->parse()
                    ->getValue();
                if ($iUser) {
                    $carry[] = $iUser
                        ->setId($this->nextId())
                        ->getAll();
                }
                return $carry;
            },
            []
        );
    }
    
    /**
     * @param bool $triggerUpd
     * @return int
     */
    protected function nextId(bool $triggerUpd = true)
    {
        if ($this->lastId !== null) {
            $nextId = $this->lastId + 1;
        } else {
            $userIds = array_column((new SessionGlob())->getUsers(), 'id');
            rsort($userIds, SORT_NUMERIC);
            $this->lastId = $userIds[0] ?? 1;
            $nextId = $this->lastId + 1;
        }
        
        if ($triggerUpd) {
            $this->lastId = $nextId;
        }
        return $nextId;
    }
}