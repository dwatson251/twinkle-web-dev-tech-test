<?php

namespace Twinkl\User\Crud;

use Exception;
use InvalidArgumentException;
use Twinkl\Core\Consts\HttpConsts;
use Twinkl\Core\Crud\BaseCrud;
use Twinkl\Core\Glob\SessionGlob;
use Twinkl\Core\Helper\Sql\SqlPlaceholderHelper;
use Twinkl\Eloquent\Model\User\User;

/**
 * Class UserReader
 * @package Twinkl\User\Crud
 */
class UserReader extends BaseCrud
{
    /**
     * @return array
     */
    public function getAll()
    {
        return $this->useSessAsDb() ? $this->processGetAllFromSess() : $this->processGetAllFromDb();
    }

    /**
     * @param int[] $userIds
     * @return array[]
     */
    public function getAllById(array $userIds)
    {
        if (!($userIds = array_filter($userIds))) {
            throw new InvalidArgumentException(
                'User IDs are not defined.',
                HttpConsts::CODE_SERVER_ERROR
            );
        }
        return $this->useSessAsDb() ?
            $this->processGetAllByIdFromSess($userIds)
            : $this->processGetAllByIdFromDb($userIds);
    }

    /**
     * @param int $userId
     * @return array|null
     */
    public function getById(int $userId)
    {
        $users = $this->getAllById([$userId]);
        return array_pop($users);
    }

    /**
     * Incredibly ambiguous method which does not describe from it's getting clearly.
     *
     * Consider better method naming to allow a better description of what these methods do.
     *
     * There were three ways to remove duplicates:
     *  - Use a group by clause, however would require listing out all columns in select as opposed to wildcard select,
     *    likely not to be the intended solution
     *  - Use a distinct clause. More likely but highly ineffecient as MySQL result set aggregate has
     *    to be scanned again to remove duplicates.
     *  - Reduce the scope of the LEFT JOINs.
     *
     * @return array[]
     */
    protected function processGetAllFromDb()
    {
        return User
            ::hydrate(
                User::returnConnection()->select('
                    SELECT
                        `u`.*
                    FROM
                        `user` AS `u`
                    LEFT JOIN
                        `subscription_user` AS `su`
                            ON
                                `su`.`user_id` = `u`.`id`
                    LEFT JOIN
                        `subscription` AS `s`
                            ON
                                `s`.`id` = `su`.`subscription_id` AND `s`.`active` = ?
                    WHERE
                        `u`.`active` = ?',
                    [1,1]
                )
            )
            ->toArray();
    }

    /**
     *
     * @return array[]
     */
    protected function processGetAllByIdFromDb(array $userIds)
    {
        $phHlpr = (new SqlPlaceholderHelper($userIds))->build();
        return User
            ::hydrate(
                User::returnConnection()->select("
                    SELECT
                        *
                    FROM
                        `user`
                    WHERE
                        `id` IN ({$phHlpr->toPlaceholderString()})
                        AND `active` = ?",
                    array_merge($phHlpr->getParams(), [1])
                )
            )
            ->toArray();
    }

    /*
     * Sess logic
     */

    /**
     * @return array[]
     */
    protected function processGetAllFromSess()
    {
        return (new SessionGlob())->getUsers() ?: [];
    }

    /**
     * @return array[]
     */
    protected function processGetAllByIdFromSess(array $userIds)
    {
        $users = array_column((new SessionGlob())->getUsers(), null, 'id');
        return array_values(
            array_intersect_key(
                $users,
                array_fill_keys($userIds, true)
            )
        );
    }
}
