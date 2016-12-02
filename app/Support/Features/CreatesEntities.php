<?php

namespace App\Support\Features;

use Exception;
use App\Entity;
use App\Option;
use Illuminate\Support\Facades\DB;

/**
 * @see \App\Entity
 */

trait CreatesEntities
{
    /**
     * Creates a new entity of a given type with their options.
     *
     * @param  mixed  $class
     * @param  mixed  $label
     * @param  array  $options
     *
     * @return bool
     */
    public static function build($class = null, $label = null, array $options = []):bool
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

        if (!$object->hasEnoughOptions($options)) {

            $missing = implode(', ', $object->getMissingOptions($options));

            throw new Exception("[{$class}] is missing required options: [{$missing}]");
        }

        $created = false;

        DB::transaction(function () use ($object, $class, $label, $options, &$created) {

            $object->type  = $class;
            $object->label = $label;

            $object->save();

            $options = collect($options)->map(function ($option, $name) use ($object) {

                $fields              = is_array($option) ? $option : [ 'value' => $option ];
                $fields['name']      = $name;
                $fields['entity_id'] = $object->id;

                return new Option($object->formatNewOption($fields));
            });

            $object->options()->saveMany($options->values()->all());

            $created = true;
        });

        return $created;
    }
}