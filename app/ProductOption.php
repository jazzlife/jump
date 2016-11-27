<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    /** @var array */
    protected $fillable = [
        'product_id',
        'name',
        'type',
        'value'
    ];
}