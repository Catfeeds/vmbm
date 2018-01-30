let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.browserSync({
    open: 'external',
    host: 'app.vmbm',
    proxy: 'app.vmbm',
    files: ['resources/views/**/*.php', 'resources/assets/**/*.js', 'resources/assets/**/*.scss', 'app/**/*.php', 'routes/**/*.php']
});