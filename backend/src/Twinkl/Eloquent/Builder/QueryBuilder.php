<?php


namespace Twinkl\Eloquent\Builder;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Database\Query\Processors\Processor;

/**
 * Class EloquentBuilder
 * @package Twinkl\Eloquent\Builder
 */
class QueryBuilder extends Builder
{
    /*
     * Properties
     */
    
    public $wheres = [];
    
    /*
     * Init
     */
    
    /**
     * QueryBuilder constructor.
     * Simple extension of base eloquent class but with couple of fixes due to PHP version.
     * @param ConnectionInterface $connection
     * @param Grammar|null $grammar
     * @param Processor|null $processor
     */
    public function __construct(
        ConnectionInterface $connection,
        Grammar $grammar = null,
        Processor $processor = null
    ) {
        parent::__construct(...func_get_args());
    
        $this->wheres = $this->wheres ?? [];
    }
}
