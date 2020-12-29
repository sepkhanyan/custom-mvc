<?php
namespace app\models;

use tm\core\base\Model;

class User extends Model
{
    protected $table = 'users';

    public $attributes = [
        'password' => '',
        'login' => '',
    ];
}