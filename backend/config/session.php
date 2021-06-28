<?php

use Twinkl\Core\Glob\SessionGlob;

session_start();
$sess = new SessionGlob();

if ($sess->getUsers() === null) {
    $sess->setUsers(
        array_map(
            static function ($iId) {
                return [
                    'id' => $iId,
                    'firstname' => "test firstname {$iId}",
                    'lastname' => "test lastname {$iId}",
                ];
            },
            [1,2,3]
        )
    );
}