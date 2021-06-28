<?php

namespace Twinkl\Core\Glob;

use Twinkl\Core\Consts\LoggerConsts;
use Twinkl\Core\Consts\ServerConsts;
use Twinkl\Core\Consts\SessionConsts;

/**
 * Class SessionGlob
 * @package Twinkl\Core\Glob
 */
class SessionGlob extends BaseArrayGlob
{
    /*
     * Getter logic
     */
    
    /**
     * @return array
     */
    public function getAll(): array
    {
        return $_SESSION;
    }
    
    /**
     * Setter logic
     */
    
    public function setAll(?array $sess)
    {
        $_SESSION = $sess ?? [];
        return $this;
    }
    
    /*
     * Users logic
     */
    
    /**
     * @return array|null
     */
    public function getUsers(): ?array
    {
        return $this->get(SessionConsts::KEY_USERS);
    }
    
    /**
     * @param array|null $users
     * @return $this
     */
    public function setUsers(?array $users)
    {
        return $this->set(SessionConsts::KEY_USERS, $users);
    }
}
