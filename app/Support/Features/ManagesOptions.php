<?php

namespace App\Support\Features;

use App\Option;

trait ManagesOptions
{
    /**
     * An entity may have many options.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(Option::class, 'entity_id')->orderBy('id', 'desc');
    }

    /**
     * Returns an option.
     *
     * @param  mixed  $name
     * @param  mixed  $default
     * @param  bool   $create
     *
     * @return mixed
     */
    public function option($name, $default = null, bool $create = false)
    {
        if (is_array($name)) {

            return $this->createNewOption($name);
        }

        if (substr($name, -1) === '.') {

            return $this->returnAllOptions($name);
        }

        return $this->returnOneOption($name, $default, $create);
    }

    /**
     * Creates a new option.
     *
     * @param  array  $fields
     *
     * @return void
     */
    protected function createNewOption(array $fields)
    {
        $fields = $this->formatNewOption($fields);
        $option = $this->options()->where('name', $fields['name'])->first();

        if ($option) {

            $option->entity_type = $fields['entity_type'];
            $option->name        = $fields['name'];
            $option->type        = $fields['type'];
            $option->value       = $fields['value'];

            $option->save();
        } else {

            $this->options()->create([
                'entity_type' => $fields['entity_type'],
                'name'        => $fields['name'],
                'type'        => $fields['type'],
                'value'       => $fields['value']
            ]);
        }

        $this->load('options');
    }

    /**
     * Formats option fields.
     *
     * @param  array  $fields
     *
     * @return array
     */
    public function formatNewOption(array $fields):array
    {
        $type  = $fields['type'] ?? '';
        $value = $fields['value'] ?? '';

        if (empty($type)) {

            if (is_int($value)) {

                $type = 'int';
            } else if (is_float($value)) {

                $type = 'float';
            } else if (is_bool($value)) {

                $type = 'bool';
            } else {

                $type = 'string';
            }
        }

        if (is_array($value)) {

            $type  = 'array';
            $value = json_encode($value);
        } else if (is_object($value) and $value instanceof stdClass) {

            $type = 'object';
            $value = json_encode($value);
        }

        return [
            'entity_type' => $fields['entity_type'] ?? get_class($this),
            'name'        => $fields['name'],
            'type'        => $type,
            'value'       => $value
        ];
    }

    /**
     * Returns a value of an option.
     *
     * @param  string $name
     * @param  mixed  $default
     * @param  bool   $create
     *
     * @return mixed
     */
    public function returnOneOption(string $name, $default = null, bool $create = false)
    {
        $option = $this->options->first(function ($option) use ($name) {
            return $option->name === $name;
        });

        if (!$option) {

            if ($create) {
                $this->createNewOption([ 'name' => $name, 'value' => $default ]);
            }

            return $default;
        }

        return $this->returnOptionValue($option);
    }

    /**
     * Returns all option values which start with the given name.
     *
     * @param  string $name
     *
     * @return array
     */
    public function returnAllOptions(string $name):array
    {
        $options = [];

        $this->options->each(function ($option) use ($name, &$options) {

            if (strpos($option->name, $name) === false and $name !== '.') {
                return;
            }

            array_set($options, preg_replace('/^' . preg_quote($name) . '/', '', $option->name), $this->returnOptionValue($option));
        });

        return $options;
    }

    /**
     * Formats the value of an option.
     *
     * @param  \App\Option $option
     *
     * @return mixed
     */
    public function returnOptionValue(Option $option)
    {
        switch ($option->type) {
            case 'string':
                return (string)$option->value;

            case 'int':
            case 'integer':
                return (int)$option->value;

            case 'float':
            case 'double':
            case 'real':
                return (float)$option->value;

            case 'bool':
            case 'boolean':
                return (bool)$option->value;

            case 'array':
                return json_decode($option->value, true) ?: [];

            case 'object':
                return json_decode($option->value) ?: new stdClass;

            case 'binary':
                return (binary)$option->value;
        }

        return (string)$option->value;
    }

    /**
     * Builds a query to find all entities of a given type.
     *
     * @param  mixed       $name
     * @param  mixed       $value
     * @param  null|string $class
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function withOption($name, $value = null, $class = null)
    {
        $class = $class ?: get_called_class();
        $query = Option::where('entity_type', $class);

        if (is_callable($name)) {

            $name($query);
        } else {

            $query->where('name', (string)$name);
        }

        if ($value) {

            $query->where('value', (string)$value);
        }

        $ids = $query->get()->map(function ($option) { return $option->entity_id; })->all();

        return (new $class)->with('options')->whereIn('id', $ids)->orderBy('id', 'desc');
    }

    /**
     * Returns all entities of a given type.
     *
     * @param  mixed       $name
     * @param  mixed       $value
     * @param  null|string $class
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function allWithOption($name, $value = null, $class = null)
    {
        return static::withOption($name, $value, $class)->get();
    }

    /**
     * Returns an entity of a given type.
     *
     * @param  mixed       $name
     * @param  mixed       $value
     * @param  null|string $class
     *
     * @return null|\App\Entity
     */
    public static function oneWithOption($name, $value = null, $class = null)
    {
        return static::withOption($name, $value, $class)->first();
    }
}