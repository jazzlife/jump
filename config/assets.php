<?php

return [

    /**
     * Remote Assets Configuration.
     */

    'use_cdn' => env('ASSETS_USE_CDN', false),

    'cdn_url' => env('ASSETS_CDN_URL', ''),

    'images_path' => env('ASSETS_IMAGES_PATH', ''),

    'styles_path' => env('ASSETS_STYLES_PATH', ''),

    'scripts_path' => env('ASSETS_SCRIPTS_PATH', ''),
];