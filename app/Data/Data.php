<?php

namespace App\Data;

class Data
{
    /** @var array */
    protected $childs = [];

    /** @var array */
    protected $cache = [];

    /**
     * Creates a custom store for the application.
     *
     * @return array
     */
    public function store()
    {
        return [];
    }

    /**
     * Creates a custom translation for the application.
     *
     * @return array
     */
    public function translation()
    {
        return [];
    }

    /**
     * Caches custom data values for the current request.
     *
     * @param  string $type
     *
     * @return array
     */
    public function build(string $type):array
    {
        if (!isset($this->cache[$type])) {

            $this->cache[$type] = (array)$this->{$type}();
        }

        return $this->cache[$type];
    }

    /**
     * Returns a value from the custom data.
     *
     * @param  string      $type
     * @param  string      $path
     * @param  string|null $default
     * @param  bool        $computed
     *
     * @return mixed
     */
    public function get($type, string $path, string $default = null, bool $computed = true)
    {
        $array = $this->toArray($type, $computed);

        return array_get($array, $path, $default);
    }

    /**
     * Updates a value in the custom data.
     *
     * @param string $type
     * @param string $path
     * @param mixed  $value
     */
    public function set($type, string $path, $value)
    {
        $this->build($type);

        array_set($this->cache[$type], $path, $value);
    }

    /**
     * Removes a value from the custom data.
     *
     * @param  string $type
     * @param  string $path
     *
     * @return void
     */
    public function remove($type, string $path)
    {
        $this->build($type);

        array_forget($this->cache[$type], $path);
    }

    /**
     * Creates an array of custom data values.
     *
     * @param  string $type
     * @param  bool   $computed
     *
     * @return array
     */
    public function toArray($type, bool $computed = true):array
    {
        $data = $this->build($type);

        if (!$computed) {
            return $data;
        }

        collect($this->childs)->each(function ($child) use (&$data, $type) {

            $data = array_replace_recursive($data, $child->toArray($type));
        });

        return $data;
    }

    /**
     * Returns the custom data values as a JSON string.
     *
     * @param  string $type
     * @param  bool   $format
     *
     * @return string
     */
    public function toJson($type, bool $format = false):string
    {
        return json_encode($this->toArray($type), $format ? JSON_PRETTY_PRINT : 0);
    }

    /**
     * Manages child data instances.
     *
     * @param  string $child
     *
     * @return \App\Data\Data
     */
    public function make(string $child = 'AppData')
    {
        $child = '\\App\\Data\\' . $child;

        if (!isset($this->childs[$child])) {

            $this->childs[$child] = new $child;
        }

        return $this->childs[$child];
    }
}