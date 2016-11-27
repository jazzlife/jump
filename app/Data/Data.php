<?php

namespace App\Data;

class Data
{
    /** @var null|array */
    protected $cachedStore;

    /** @var null|array */
    protected $cachedTranslation;

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
     * Caches custom data for the current request.
     *
     * @param  string $type
     *
     * @return string
     */
    public function build(string $type):string
    {
        $name = strtolower($type);
        $cache = 'cached' . ucfirst($name);

        if (null === $this->{$cache}) {

            $this->{$cache} = (array)$this->{$name}();
        }

        return $cache;
    }

    /**
     * Returns a value from the custom data.
     *
     * @param  string      $type
     * @param  string      $path
     * @param  string|null $default
     *
     * @return mixed
     */
    public function get($type, string $path, string $default = null)
    {
        $cache = $this->build($type);

        return array_get($this->{$cache}, $path, $default);
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
        $cache = $this->build($type);

        array_set($this->{$cache}, $path, $value);
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
        $cache = $this->build($type);

        array_forget($this->{$cache}, $path);
    }

    /**
     * Returns the custom data as a JSON string.
     *
     * @param  string $type
     * @param  bool   $format
     *
     * @return string
     */
    public function toJson($type, bool $format = false):string
    {
        $cache = $this->build($type);

        return json_encode($this->{$cache}, $format ? JSON_PRETTY_PRINT : 0);
    }

    /**
     * Manages custom data instances.
     *
     * @param  string $child
     *
     * @return \App\Data\Data
     */
    public function make(string $child = 'AppData')
    {
        $child = '\\App\\Data\\' . $child;

        if (!isset($this->instances[$child])) {

            $this->instances[$child] = new $child;
        }

        return $this->instances[$child];
    }
}