<?php

namespace App;

class User extends Model
{
    use Support\Users\Authenticable;

    /** @var array */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}