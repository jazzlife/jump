<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

class Asset
{
    /** Specifies how long, in seconds, assets should be cached. */
    const CACHE_TIME = 31536000;

    /**
     * Returns full URL to an asset.
     *
     * @param  string $path
     * @param  bool   $cdn
     *
     * @return string
     */
    public function url(string $path, bool $cdn = true):string
    {
        $real_path = base_path('public' . $path);
        $id        = '';

        if (is_file($real_path)) {
            $id = sha1_file($real_path);
        }

        if (config('assets.use_cdn') and $cdn) {

            $cdn_url = config('assets.cdn_url');

            if ($cdn_url) {
                return $this->cdn($cdn_url, $path, $id);
            }
        }

        return $this->local($path, $id);
    }

    /**
     * Returns full URL to a local asset.
     *
     * @param  string $path
     * @param  string $id
     *
     * @return string
     */
    public function local(string $path, string $id):string
    {
        return url("{$path}?v={$id}");
    }

    /**
     * Returns full URL to a remote asset.
     *
     * @param  string $url
     * @param  string $path
     * @param  string $id
     *
     * @return string
     */
    public function cdn(string $url, string $path, string $id):string
    {
        $info = pathinfo($path);

        return "{$url}{$info['dirname']}/{$id}-{$info['filename']}.{$info['extension']}";
    }

    /**
     * Lists assets in a directory based on a given pattern.
     *
     * @param  string $pattern
     *
     * @return array
     */
    public function list(string $pattern):array
    {
        return glob(base_path("public/{$pattern}"), GLOB_BRACE);
    }

    /**
     * Creates CSS code to represent all image assets.
     *
     * @param  string $dir
     * @param  bool   $fresh
     * @param  string $prefix
     *
     * @return string
     */
    public function images(string $dir = 'images/', bool $fresh = false, string $prefix = ''):string
    {
        $pattern = '*.{jpg,jpeg,png,gif}';
        $key     = 'assets.' . md5($dir . $pattern);

        if (!$fresh) {

            $cache = Cache::get($key);

            if ($cache) {
                return $cache;
            }
        }

        $files   = $this->list($dir . $pattern);
        $regular = [];
        $retina  = [];

        collect($files)->each(function ($file) use (&$regular, &$retina, $dir, $prefix) {

            $path  = '/' . ltrim($dir, '/') . basename($file);
            $class = pathinfo($path, PATHINFO_FILENAME);
            $class = preg_replace('/\@2x$/', '$1', $class);
            $class = 'img--' . $prefix . str_slug($class);

            if (strpos($file, '@2x.') !== false) {

                $retina[] = [
                    'path'  => $path,
                    'class' => $class,
                ];
            } else {
                $size = @getimagesize($file);

                $regular[] = [
                    'path'   => $path,
                    'class'  => $class,
                    'width'  => $size[0] ?? 0,
                    'height' => $size[1] ?? 0,
                ];
            }
        });

        if (empty($regular)) {
            return;
        }

        $compiled  = $this->compileRegularImages($regular);
        $compiled .= $this->compileRetinaImages($retina);

        Cache::forever($key, $compiled);

        return $compiled;
    }

    /**
     * Creates CSS code for regular images.
     *
     * @param  array  $images
     *
     * @return string
     */
    public function compileRegularImages(array $images):string
    {
        if (empty($images)) {
            return '';
        }

        $compiled = '';

        collect($images)->each(function ($image) use (&$compiled) {
            $compiled .= ".{$image['class']}{";
            $compiled .= "background-image:url({$this->url($image['path'])});";
            $compiled .= "background-size:{$image['width']}px {$image['height']}px;";
            $compiled .= "background-position:0 0;background-repeat:no-repeat";
            $compiled .= "}";
        });

        return $compiled;
    }

    /**
     * Creates CSS code for retina images.
     *
     * @param  array  $images
     *
     * @return string
     */
    public function compileRetinaImages(array $images):string
    {
        if (empty($images)) {
            return '';
        }

        $compiled  = '@media only screen and (-webkit-min-device-pixel-ratio:1.5),';
        $compiled .= 'only screen and (min--moz-device-pixel-ratio:1.5),';
        $compiled .= 'only screen and (min-resolution:1.5dppx),';
        $compiled .= 'only screen and (min-resolution:144dpi){';

        collect($images)->each(function ($image) use (&$compiled) {
            $compiled .= ".{$image['class']}{background-image:url({$this->url($image['path'])})}";
        });

        $compiled .= '}';

        return $compiled;
    }

    /**
     * Sends all assets of a given type to the S3 storage.
     *
     * @param  string $type
     *
     * @return void
     */
    public function push(string $type)
    {
        $path = config("assets.{$type}_path");

        if (!$path) {
            return;
        }

        $paths   = explode(',', $path);
        $pattern = '*.{jpg,jpeg,png,gif}';
        $pattern = $type === 'styles' ? '*.css' : $pattern;
        $pattern = $type === 'scripts' ? '*.js' : $pattern;

        collect($paths)->each(function ($path) use ($pattern) {

            $path = trim($path);

            if (empty($path)) {
                return;
            }

            storage()->disk('s3')->makeDirectory($path);
            storage()->disk('s3')->delete(storage()->disk('s3')->files($path));

            $files = $this->list($path . $pattern);

            collect($files)->each(function ($file) use ($path) {

                storage()->disk('s3')->getDriver()->put(
                    $path . sha1_file($file) . '-' . basename($file),
                    file_get_contents($file), [
                        'visibility'   => 'public',
                        'Expires'      => gmdate('D, d M Y H:i:s \G\M\T', time() + static::CACHE_TIME),
                        'CacheControl' => 'public, max-age=' . static::CACHE_TIME,
                    ]
                );
            });
        });
    }
}