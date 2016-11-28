<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /** @var string */
    protected $table = 'options';

    /** @var array */
    protected $fillable = [
        'entity_id',
        'entity_type',
        'name',
        'type',
        'value'
    ];
}