const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

//TODO : COMPILE FRONTEND ASSETS

// FRONT VERSION 1
// mix.js([
//     'resources/front-v1/js/owlcarousel/owl.carousel.js',
//     'resources/front-v1/js/owlcarousel/owl.video.js',
//     'resources/front-v1/js/jquery.min.js',
//     'resources/front-v1/js/popper.min.js',
//     'resources/front-v1/js/lazyload.min.js',
//     'resources/front-v1/js/bootstrap.min.js',
//     ], 'public/front-v1/js/all.js');
//
// mix.styles([
//     'resources/front-v1/css/font-awesome/css/font-awesome.css',
//     'resources/front-v1/css/owlcarousel/owl.carousel.min.css',
//     'resources/front-v1/css/owlcarousel/owl.theme.default.min.css',
//     'resources/front-v1/css/bootstrap.min.css',
//     'resources/front-v1/css/bootstrap-rtl.min.css',
//     'resources/front-v1/css/main.css',
// ], 'public/front-v1/css/all.css');
