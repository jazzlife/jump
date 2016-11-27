<?php

namespace App\Support\Features;

use App\ProductOption;

trait ManagesProductOptions
{
    /**
     * A product may have many options.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(ProductOption::class);
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

            $option->name  = $fields['name'];
            $option->type  = $fields['type'];
            $option->value = $fields['value'];

            $option->save();
        } else {

            $this->options()->create([
                'name'  => $fields['name'],
                'type'  => $fields['type'],
                'value' => $fields['value']
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
            'name'  => $fields['name'],
            'type'  => $type,
            'value' => $value
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
     * @param  \App\ProductOption $option
     *
     * @return mixed
     */
    public function returnOptionValue(ProductOption $option)
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

            case 'binary':
                return (binary)$option->value;

            case 'array':
                return json_decode($option->value, true) ?: [];

            case 'object':
                return json_decode($option->value) ?: new stdClass;
        }

        return (string)$option->value;
    }
}