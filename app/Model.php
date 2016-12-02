<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
    /**
     * Specify that the ID is non-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Initializes default attribute values.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $attr = (array)$this->init();

        if (!isset($attr['id'])) {
            $attr['id'] = $this->uid();
        }

        $this->setRawAttributes($attr);

        parent::__construct($attributes);
    }

    /**
     * Registers an handler to cleanup related tables when a model is being deleted.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            return static::cleanup($model);
        });
    }

    /**
     * Specifies default attribute values.
     *
     * @return array
     */
    protected function init()
    {
        return [];
    }

    /**
     * Generates an unique ID for every row.
     *
     * @return int
     */
    protected function uid()
    {
        if (PHP_INT_SIZE < 8) {
            return random_int(1000000, 9000000) . random_int(1000000, 9000000);
        }

        return random_int(10000000000000, 90000000000000);
    }

    /**
     * Cleanup related tables when a model is being deleted.
     *
     * @param  \App\Model  $model
     *
     * @return void
     */
    protected static function cleanup($model)
    {

    }
}