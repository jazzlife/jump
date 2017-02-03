<?php

namespace App\Support;

use App\Support\Assets\ImageIterator;
use Illuminate\Support\Facades\Cache;

class Asset
{
    /**
     * Creates a cache key.
     *
     * @param  string $id
     *
     * @return string
     */
    public function key(string $id):string
    {
        return 'asset.' . sha1($id);
    }

    /**
     * Adds an item to the assets cache.
     *
     * @param string $id
     * @param string $content
     */
    public function cache(string $id, string $content):string
    {
        Cache::tags('assets')->forever($this->key($id), $content);

        return $content;
    }

    /**
     * Retreives an item from the assets cache.
     *
     * @param  string $id
     *
     * @return string
     */
    public function get(string $id):string
    {
        return (string)Cache::tags('assets')->get($this->key($id));
    }

    /**
     * Clears the assets cache.
     *
     * @return void
     */
    public function flush()
    {
        Cache::tags('assets')->flush();
    }

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
     * Returns CSS representation of all images in a directory.
     *
     * @param  string $dir
     * @param  string $prefix
     *
     * @return string
     */
    public function css(string $dir = 'images', string $prefix = ''):string
    {
        return $this->get($dir) ?: $this->cache($dir, (new ImageIterator($dir, $prefix))->css());
    }
}