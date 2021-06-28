<?php


namespace Twinkl\Eloquent\Model\Subscription;


use Twinkl\Eloquent\Model\EloquentModel;

/**
 * Class Subscription
 * @package Twinkl\Eloquent\Model\Subscription
 */
class Subscription extends EloquentModel
{
    /*
     * Properties
     */
    
    protected $table = 'subscription';
    protected $guarded = ['id'];
}
