<?php

namespace Twinkl\Eloquent\Model;

use Exception;
use Illuminate\Database\Query\{Expression, Builder as LaravelQueryBuilder};
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\{Model, Builder as LaravelEloquentBuilder};
use LogicException;
use Twinkl\Core\Entity\IEntity;
use Twinkl\Core\Parser\Entity\EntityParser;
use Twinkl\Eloquent\Builder\EloquentBuilder;
use Twinkl\Eloquent\Builder\QueryBuilder;
use Twinkl\Eloquent\Util\EloquentUtils;

/**
 * Class EloquentModel
 * @package Twinkl\Model\Eloquent
 */
class EloquentModel extends Model
{
    /*
     * Consts
     */

    /**
     * Qualified classname of entity for this model
     * @var null|string
     */
    public const ENTITY_CLASS = null;

    /*
     * Properties
     */

    /**
     * @var array
     */
    protected $rules = [];
    /**
     * @var array
     */
    protected $errors = [];

    /*
     * Init logic
     */

    /**
     * EloquentModel constructor.
     * @param null|array $attrs
     */
    public function __construct($attrs = null)
    {
        $this->initTwinklConnections();
        parent::__construct($attrs ?: []);
    }
    
    /**
     * @return $this
     */
    protected function initTwinklConnections()
    {
        EloquentUtils
            ::getInstance()
            ->initConnections();
        return $this;
    }

    /*
     * Ids logic
     */

    /**
     * @param null|string $col
     * @return int|string|null
     */
    public function returnLatestId($col = null)
    {
        $col = $col ?? 'id';
        if ($result = static::latest($col)) {
            return $result->first()->$col;
        }
        return null;
    }

    /**
     * @param null|int $lastId
     * @param null|int $rowCount
     * @param null|array $return
     * @return array
     */
    public function returnLastInsertIds(int $lastId = null, int $rowCount = null, array $return = null)
    {
        $return = $return ?: [];
        $lastId = $lastId ?? $this
            ->getConnection()
            ->getPdo()
            ->lastInsertId();
        
        if (($lastId > 0)
            && ($rowCount > 0)
        ) {
            for ($i = 0; $i < $rowCount; $i++) {
                $return[] = ($lastId + $i);
            }
        }
    
        return $return;
    }
    
    /*
     * Config logic
     */

    /**
     * Returns current model's attributes as an entity
     * @param string|null $entClass
     * @param bool        $triggerSan
     * @return IEntity
     * @throws Exception
     */
    public function returnEntity(string $entClass = null)
    {
        return (new EntityParser($this->getAttributes(), null, $entClass))
            ->getValue();
    }

    /*
     * Builder logic
     */

    /**
     * Overrides original method to use custom extended class containing fixes.
     * @param LaravelQueryBuilder $query
     * @return LaravelEloquentBuilder|EloquentBuilder
     */
    public function newEloquentBuilder($query)
    {
        return new EloquentBuilder($query);
    }
    
    /**
     * @return LaravelQueryBuilder|QueryBuilder
     */
    public function newQueryBuilder()
    {
        return $this->newBaseQueryBuilder();
    }

    /**
     * Overrides original method to use custom extended class containing fixes.
     * @return LaravelQueryBuilder|QueryBuilder
     */
    protected function newBaseQueryBuilder()
    {
        $conn = $this->getConnection();
        $grammar = $conn->getQueryGrammar();
        return new QueryBuilder($conn, $grammar, $conn->getPostProcessor());
    }

    /*
     * Table logic
     */

    /**
     * Returns current model's table name and optionally include prefix.
     * @param bool $includePrefix
     * @return string
     */
    public function returnTableName(bool $includePrefix = true): string
    {
        return (
            ($includePrefix ? $this->getConnection()->getTablePrefix() : '')
            . $this->getTable()
        );
    }
    
    /**
     * @param bool $includePrefix
     * @return string
     */
    public static function returnModelTableName(bool $includePrefix = true): string
    {
        return (new static())->returnTableName($includePrefix);
    }
    
    /*
     * Query logic
     */
    
    /**
     * @param mixed $query
     * @return Expression
     */
    public static function rawQuery($query): Expression
    {
        return new Expression($query);
    }
    
    /*
     * Connection logic
     */
    
    /**
     * @return Connection
     */
    public static function returnConnection(): Connection
    {
        return (new static())->getConnection();
    }
}
