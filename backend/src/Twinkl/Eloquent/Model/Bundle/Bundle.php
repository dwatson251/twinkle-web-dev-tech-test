<?php


namespace Twinkl\Eloquent\Model\Bundle;


use Twinkl\Eloquent\Model\EloquentModel;

/**
 * Class Bundle
 * @package Twinkl\Eloquent\Model\Bundle
 */
class Bundle extends EloquentModel
{
    /*
     * Properties
     */
    
    protected $table = 'bundle';
    protected $guarded = ['id'];
}
