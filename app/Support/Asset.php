<?php

namespace App\Support;

use App\Support\Assets\ImageIterator;

class Asset
{
    /**
     * Returns full URL to an asset.
     *
     * @param  string $path
     *
     * @return string
     */
    public function url(string $path):string
    {
        $path      = '/' . trim($path, '/');
        $real_path = base_path("public{$path}");
        $version   = is_file($real_path) ? sha1(filemtime($real_path)) : '';

        return url("{$path}?v={$version}");
    }

    /**
     * Returns an instance of Images Manager.
     *
     * @param  string $dir
     * @param  string $prefix
     *
     * @return \App\Support\Images
     */
    public function images(string $dir = 'images', string $prefix = '')
    {
        return new ImageIterator($dir, $prefix);
    }
}