<?php

namespace app\models;

use tm\core\base\Model;

class Task extends Model
{
    protected $table = 'tasks';

    public  $attributes = [
        'performer' => '',
        'email' => '',
        'description' => '',
        'status' => '',
        'edited' => '',
    ];

    public $rules = [
        'required' => [
            ['performer'],
            ['email'],
            ['description']
        ],

        'email' => [
            ['email']
        ]
    ];
}