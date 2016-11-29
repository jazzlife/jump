
const del    = require('del');
const gulp   = require('gulp');
const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/**
 * Remove special comments.
 */

elixir.config.css.minifier.pluginOptions.keepSpecialComments = 0;

/**
 * Register a cleanup task.
 */

elixir.extend('cleanup', function(path) {
    new elixir.Task('cleanup', function () {
        return del(path);
    });
});

/**
 * Register a del task.
 */

elixir.extend('del', function (path) {
    new elixir.Task('del', function () {
        del(path);
    });
});

/**
 * Run the tasks.
 */

elixir(mix => {

    /**
     * Remove existing CSS/JavaScript files before a new build.
     */

    mix.cleanup([ './public/js', './public/css' ]);

    /**
     * Compile Stylus files.
     */

    mix.stylus('app.styl');

    /**
     * Compile JavaScript files.
     */

    mix.webpack('app.js');

    /**
     * Merge CSS files.
     */

    mix.styles([
        './public/css/app.css',
    ], './public/css/bundle.css');

    /**
     * Merge JavaScript files.
     */

    mix.scripts([
        './public/js/app.js',
    ], './public/js/bundle.js');

    /**
     * Remove unused CSS files.
     */

    mix.del([
        './public/css/app.css',
    ]);

    /**
     * Remove unused JavaScript files.
     */

    mix.del([
        './public/js/app.js',
    ]);
});