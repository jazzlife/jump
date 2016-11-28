<?php

namespace App;

use stdClass;
use Exception;
use Illuminate\Support\Facades\DB;
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
     * Minimum number of required options to create a new entity.
     *
     * @var array
     */
    protected $requires = [];

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

    /**
     * Creates a new entity of a given type with their options.
     *
     * @param  mixed  $class
     * @param  mixed  $label
     * @param  array  $options
     *
     * @return \App\Entity
     */
    public static function build($class = null, $label = null, array $options = [])
    {
        if (is_array($class)) {

            $options = $class;
            $class   = null;
        }

        if (is_array($label)) {

            $options = $label;
            $label   = null;
        }

        $class  = $class ?: get_called_class();
        $object = new $class;

        if (!$object instanceof Entity) {

            throw new Exception("[{$class}] must be an instance of [\\App\\Entity]");
        }

        $diff = array_diff($object->requires, array_keys($options));

        if (!empty($diff)) {

            $diff = implode(', ', $diff);

            throw new Exception("[{$class}] missing required options: [{$diff}]");
        }

        DB::transaction(function () use ($object, $class, $label, $options) {

            $object->type  = $class;
            $object->label = $label;

            $object->save();

            $options = collect($options)->map(function ($option, $key) use ($object) {

                $fields              = is_array($option) ? $option : [ 'value' => $option ];
                $fields['name']      = $key;
                $fields['entity_id'] = $object->id;

                return new Option($object->formatNewOption($fields));
            });

            $object->options()->saveMany($options->values()->all());
        });

        return $object;
    }
}