<?php

namespace Twinkl\Eloquent\Builder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * Class EloquentBuilder
 * @package Twinkl\Eloquent\Builder
 */
class EloquentBuilder extends Builder
{
    /*
     * Properties
     */
    
    /**
     * @var array
     */
    public $wheres = [];
    
    /*
     * Init logic
     */
    
    /**
     * EloquentBuilder constructor.
     * Simple extension of base eloquent class but with couple of fixes due to PHP version.
     * @param QueryBuilder $query
     */
    public function __construct($query)
    {
        parent::__construct(...func_get_args());
        
        $this->wheres = $this->wheres ?? [];
    }
}
