<?php

namespace App\Support\Assets;

use SplFileInfo;

class Image extends SplFileInfo
{
    /** @var string */
    protected $dir;

    /** @var string */
    protected $prefix;

    /** @var array */
    protected $dimensions;

    /**
     * Initializes a new Image.
     *
     * @param string $path
     * @param string $dir
     * @param string $prefix
     */
    public function __construct(string $path, string $dir, string $prefix)
    {
        $this->dir    = $dir;
        $this->prefix = $prefix;

        parent::__construct($path);
    }

    /**
     * Determines if the image is retina.
     *
     * @return bool
     */
    public function isRetina():bool
    {
        return false !== strpos($this->getFilename(), '@2x.');
    }

    /**
     * Returns the class name for the image.
     *
     * @return string
     */
    public function getClass():string
    {
        return '.img--' . $this->prefix . str_slug(strtr($this->getBasename(".{$this->getExtension()}"), [ '@2x' => '' ]));
    }

    /**
     * Returns the URL to the image.
     *
     * @return string
     */
    public function getURL():string
    {
        return "/{$this->dir}/{$this->getFilename()}";
    }

    /**
     * Returns image dimensions.
     *
     * @param  int    $index
     *
     * @return int
     */
    public function getDimensions(int $index):int
    {
        if (!$this->dimensions) {

            $this->dimensions = @getimagesize($this->getRealpath());
        }

        return $this->dimensions[$index] ?? 0;
    }

    /**
     * Returns image width.
     *
     * @return int
     */
    public function getWidth():int
    {
        return $this->getDimensions(0);
    }

    /**
     * Returns image height.
     *
     * @return int
     */
    public function getHeight():int
    {
        return $this->getDimensions(1);
    }

    /**
     * Returns CSS representation of the image.
     *
     * @return string
     */
    public function css():string
    {
        if ($this->isRetina()) {
            return '';
        }

        return "{$this->getClass()}{" .
               "background-image:url({$this->getURL()});" .
               "background-size:{$this->getWidth()}px {$this->getHeight()}px;" .
               "background-position:0 0;" .
               "background-repeat:no-repeat}";
    }

    /**
     * Returns retina CSS representation of the image.
     *
     * @return string
     */
    public function rcss():string
    {
        if (!$this->isRetina()) {
            return '';
        }

        return "{$this->getClass()}{background-image:url({$this->getURL()})}";
    }
}