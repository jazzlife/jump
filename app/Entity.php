<?php

namespace App;

use App\Support\Features\ManagesOptions;
use App\Support\Features\CreatesEntities;

class Entity extends Model
{
    use ManagesOptions;
    use CreatesEntities;

    /** @var string */
    protected $table = 'entities';

    /** @var array */
    protected $fillable = [
        'type',
        'label'
    ];

    /**
     * Specifies default attribute values.
     *
     * @return array
     */
    public function init()
    {
        return [
            'type' => get_class($this)
        ];
    }
}