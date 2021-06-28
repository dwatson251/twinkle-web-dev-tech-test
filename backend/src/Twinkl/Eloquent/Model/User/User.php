<?php


namespace Twinkl\Eloquent\Model\User;


use Twinkl\Eloquent\Model\EloquentModel;

/**
 * Class User
 * @package Twinkl\Eloquent\Model\User
 */
class User extends EloquentModel
{
    /*
     * Properties
     */
    
    protected $table = 'user';
    protected $guarded = ['id'];
}
