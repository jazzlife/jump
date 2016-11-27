<?php

namespace App;

use stdClass;
use Illuminate\Database\Eloquent\Model;
use App\Support\Features\ManagesProductOptions;

class Product extends Model
{
    use ManagesProductOptions;

    /** @var array */
    protected $fillable = [
        'key'
    ];

    /**
     * Creates an unique key for every row.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setRawAttributes([
            'key' => random_int(1000000000, 9000000000)
        ]);

        parent::__construct($attributes);
    }
}