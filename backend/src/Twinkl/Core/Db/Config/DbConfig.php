<?php


namespace Twinkl\Core\Db\Config;

use PDO;
use Twinkl\Core\Consts\DbConsts;
use Twinkl\Core\CustomTrait\Handler\Data\DataAssocArrayHandlerTrait;
use Twinkl\Core\Helper\ArrayExt\ArrayHelper;
use Twinkl\Eloquent\Consts\EloquentConsts;

/**
 * Class DbConfig
 * @package Twinkl\Core\Db\Config
 */
class DbConfig
{
    /*
     * Traits
     */
    
    use DataAssocArrayHandlerTrait;
    
    /*
     * Data logic
     */
    
    public function getDefaultAll(): array
    {
        return [
            'driver'        => DbConsts::DRIVER_MYSQL,
            'host'          => null,
            'database'      => null,
            'username'      => null,
            'password'      => null,
            'charset'       => DbConsts::CHARSET_UTF8,
            'collation'     => DbConsts::COLLATE_UTF8,
            'port'          => DbConsts::PORT_DEV,
            'fetch_mode'    => PDO::FETCH_ASSOC,
        ];
    }
    
    /*
     * Driver logic
     */
    
    /**
     * @return string|null
     */
    public function getDriver(): ?string
    {
        return $this->get('driver');
    }
    
    /**
     * @param string|null $driver
     * @return $this
     */
    public function setDriver(?string $driver)
    {
        return $this->set('driver', $driver);
    }
    
    /*
     * Host logic
     */
    
    /**
     * @return string|null
     */
    public function getHost(): ?string
    {
        return $this->get('host');
    }
    
    /**
     * @param string|null $host
     * @return $this
     */
    public function setHost(?string $host)
    {
        return $this->set('host', $host);
    }
    
    /*
     * Database logic
     */
    
    /**
     * @return string|null
     */
    public function getDatabase(): ?string
    {
        return $this->get('database');
    }
    
    /**
     * @param string|null $database
     * @return $this
     */
    public function setDatabase(?string $database)
    {
        return $this->set('database', $database);
    }
    
    /*
     * Username logic
     */
    
    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->get('username');
    }
    
    /**
     * @param string|null $username
     * @return $this
     */
    public function setUsername(?string $username)
    {
        return $this->set('username', $username);
    }
    
    /*
     * Password logic
     */
    
    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->get('password');
    }
    
    /**
     * @param string|null $password
     * @return $this
     */
    public function setPassword(?string $password)
    {
        return $this->set('password', $password);
    }
    
    /*
     * Charset logic
     */
    
    /**
     * @return string|null
     */
    public function getCharset(): ?string
    {
        return $this->get('charset');
    }
    
    /**
     * @param string|null $charset
     * @return $this
     */
    public function setCharset(?string $charset)
    {
        return $this->set('charset', $charset);
    }
    
    /*
     * Collation logic
     */
    
    /**
     * @return string|null
     */
    public function getCollation(): ?string
    {
        return $this->get('collation');
    }
    
    /**
     * @param string|null $collation
     * @return $this
     */
    public function setCollation(?string $collation)
    {
        return $this->set('collation', $collation);
    }
    
    /*
     * Prefix logic
     */
    
    /**
     * @return string|null
     */
    public function getPrefix(): ?string
    {
        return $this->get('prefix');
    }
    
    /**
     * @param string|null $prefix
     * @return $this
     */
    public function setPrefix(?string $prefix)
    {
        return $this->set('prefix', $prefix);
    }
    
    /*
     * Config logic
     */
    
    /**
     * @return string[]
     */
    public function returnEloquentCapsuleConfig(): array
    {
        return (new ArrayHelper($this->data))
            ->filterEmptyAllAt(EloquentConsts::DB_CONN_KEYS);
    }
}