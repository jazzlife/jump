
var webpack = require('webpack');

module.exports = {

    plugins: [

        // Make the most used modules available globally
        // without require-ing them each time.
        new webpack.ProvidePlugin({

            // 'name': __dirname + '/resources/assets/js/modules/name',
        })
    ],

    vue: {
        postcss: [
            require('lost'),
            require('css-mqpacker'),
            require('autoprefixer')({ remove: false }),
            require('cssnano')({ zindex: false })
        ]
    },

    stylus: {
        use: [
            require('rupture')()
        ],
        import: [
            __dirname + '/resources/assets/stylus/bootstrap'
        ]
    }
}