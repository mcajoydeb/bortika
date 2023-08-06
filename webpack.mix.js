const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
.js('resources/js/admin/admin.js', 'public/js/admin.js')
.js('resources/js/public/public.js', 'public/js/public.js')
.js('resources/js/admin/cropper.js', 'public/js/cropper.js')
.postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
]).postCss('resources/css/admin.css', 'public/css/admin.css')
.postCss('resources/css/public.css', 'public/css/public.css')
.postCss('resources/css/cropper.css', 'public/css/cropper.css');
