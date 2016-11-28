<?php

namespace App;

use stdClass;
use Illuminate\Database\Eloquent\Model;
use App\Support\Features\ManagesOptions;

class Entity extends Model
{
    use ManagesOptions;

    /** @var string */
    protected $table = 'entities';

    /** @var array */
    protected $fillable = [
        'key',
        'type',
        'label'
    ];

    /**
     * Initializes default attribute values.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setRawAttributes([
            'key'  => random_int(100000000000, 900000000000),
            'type' => get_class($this)
        ]);

        parent::__construct($attributes);
    }
}