<?php

namespace App\Meta;

class Meta
{
    /** @var array */
    protected $childs = [];

    /** @var array */
    protected $fields = [];

    /**
     * Fields which must be represented as regular HTML tags.
     *
     * @var array
     */
    protected $tags = [
        'title',
    ];

    /**
     * Fields which must be represented as opengraph properties.
     *
     * @var array
     */
    protected $opengraph = [
        'type',
        'image',
        'url',
    ];

    /**
     * Fields which must be represented both as HTML tags and as opengraph properties.
     *
     * @var array
     */
    protected $tagDouble = [
        'title',
    ];

    /**
     * Fields which must be represented both as meta tags and as opengraph properties.
     *
     * @var array
     */
    protected $metaDouble = [
        'description',
    ];

    /**
     * Sets default meta fields.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Adds a new meta field via a method call.
     *
     * @param  string $name
     * @param  array  $arguments
     *
     * @return void
     */
    public function __call($name, $arguments)
    {
        return $this->set($name, $arguments[0] ?? '', $arguments[1] ?? 'meta');
    }

    /**
     * Adds a new meta field via a property value assign.
     *
     * @param  string $name
     * @param  mixed  $value
     *
     * @return void
     */
    public function __set($name, $value)
    {
        return $this->set($name, $value);
    }

    /**
     * Returns a meta field content value via a property.
     *
     * @param  string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Initializes default meta fields.
     *
     * @return void
     */
    public function init()
    {

    }

    /**
     * Adds a new meta field.
     *
     * @param  string $name
     * @param  mixed  $content
     * @param  string $type
     *
     * @return void
     */
    public function set(string $name, $content, string $type = 'meta')
    {
        if (in_array($name, $this->tagDouble)) {

            $this->fields[$name]        = [ 'content' => $content, 'type' => 'tag' ];
            $this->fields["og:{$name}"] = [ 'content' => $content, 'type' => 'opengraph' ];
        } else if (in_array($name, $this->metaDouble)) {

            $this->fields[$name]        = [ 'content' => $content, 'type' => 'meta' ];
            $this->fields["og:{$name}"] = [ 'content' => $content, 'type' => 'opengraph' ];
        } else if (in_array($name, $this->opengraph)) {

            $this->fields["og:{$name}"] = [ 'content' => $content, 'type' => 'opengraph' ];
        } else if (in_array($name, $this->tags)) {

            $this->fields[$name] = [ 'content' => $content, 'type' => 'tag' ];
        } else {

            $this->fields[$name] = [ 'content' => $content, 'type' => $type ];
        }
    }

    /**
     * Returns the content value of a meta field.
     *
     * @param  string $name
     * @param  bool   $computed
     *
     * @return mixed
     */
    public function get(string $name, bool $computed = true)
    {
        return $this->fields($computed)[$name]['content'] ?? '';
    }

    /**
     * Removes a meta field.
     *
     * @param  string $name
     *
     * @return void
     */
    public function remove(string $name)
    {
        unset($this->fields[$name]);
    }

    /**
     * Returns all meta fields as an array.
     *
     * @param  bool   $computed
     *
     * @return array
     */
    public function fields(bool $computed = true):array
    {
        if (!$computed) {
            return $this->fields;
        }

        $fields = $this->fields;

        collect($this->childs)->each(function ($child) use (&$fields) {

            $fields = array_replace($fields, $child->fields());
        });

        return $fields;
    }

    /**
     * Creates HTML code to represent all meta fields.
     *
     * @return string
     */
    public function toHtml():string
    {
        $html = '';

        collect($this->fields())->each(function ($field, $name) use (&$html) {

            if ($field['type'] === 'opengraph' or $field['type'] === 'og') {

                $html .= '<meta property="' . e($name) . '" content="' . e($field['content']) . '">' . PHP_EOL;
            } else if ($field['type'] === 'tag') {

                $html .= '<' . e($name) . '>' . e($field['content']) . '</' . e($name) . '>' . PHP_EOL;
            } else {

                $html .= '<meta name="' . e($name) . '" content="' . e($field['content']) . '">' . PHP_EOL;
            }
        });

        return $html;
    }

    /**
     * Manages child meta instances.
     *
     * @param  string $child
     *
     * @return \App\Meta\Meta
     */
    public function make(string $child = 'AppMeta')
    {
        $child = '\\App\\Meta\\' . $child;

        if (!isset($this->childs[$child])) {

            $this->childs[$child] = new $child;
        }

        return $this->childs[$child];
    }
}