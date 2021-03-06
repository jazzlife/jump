
const del        = require('del');
const gulp       = require('gulp');
const elixir     = require('laravel-elixir');
const poststylus = require('poststylus');

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

    if (elixir.config.production) {

        mix.cleanup([ './public/js', './public/css' ]);
    }

    /**
     * Compile Stylus files.
     */

    mix.stylus('app.styl', null, {
        use: [
            require('rupture')(),
            poststylus([
                require('lost'),
                require('css-mqpacker'),
                require('autoprefixer')({ remove: false })
            ])
        ]
    });

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

    if (elixir.config.production) {

        mix.del([
            './public/css/app.css',
        ]);
    }

    /**
     * Remove unused JavaScript files.
     */

    if (elixir.config.production) {

        mix.del([
            './public/js/app.js',
        ]);
    }
});