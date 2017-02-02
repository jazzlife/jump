<?php

namespace App\Support\Assets;

use RegexIterator;
use FilesystemIterator;

class ImageIterator extends RegexIterator
{
    /** @var string */
    protected $dir;

    /** @var string */
    protected $path;

    /** @var string */
    protected $prefix;

    /** @var string */
    protected $css = '';

    /** @var string */
    protected $rcss = '';

    /** @var string */
    protected $pattern = '/\.(png|jpe?g|gif)$/';

    /**
     * Initializes Iterator.
     *
     * @param string $dir
     */
    public function __construct(string $dir, string $prefix)
    {
        $this->dir    = trim($dir, '/');
        $this->path   = base_path("public/{$this->dir}");
        $this->prefix = $prefix;

        parent::__construct(new FilesystemIterator($this->path), $this->pattern);
    }

    /**
     * Returns information about current image.
     *
     * @return \App\Support\Assets\Image
     */
    public function current()
    {
        return new Image($this->getRealPath(), $this->dir, $this->prefix);
    }

    /**
     * Iterates over all images in the directory.
     *
     * @return void
     */
    public function iterate()
    {
        collect($this)->each([ $this, 'assign' ]);
    }

    /**
     * Collects CSS for all images in the directory.
     *
     * @param  \App\Support\Assets\Image  $image
     *
     * @return void
     */
    public function assign(Image $image)
    {
        $this->css  .= $image->css();
        $this->rcss .= $image->rcss();
    }

    /**
     * Returns CSS representation for all images in the directory.
     *
     * @return string
     */
    public function css():string
    {
        $this->iterate();

        if (empty($this->rcss)) {

            return $this->css;
        }

        $this->rcss = '@media only screen and (-webkit-min-device-pixel-ratio:1.5),' .
                      'only screen and (min--moz-device-pixel-ratio:1.5),' .
                      'only screen and (min-resolution:1.5dppx),' .
                      'only screen and (min-resolution:144dpi){' .
                          $this->rcss .
                      '}';

        return $this->css . $this->rcss;
    }
}