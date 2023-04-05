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
  
mix.js('src/frontend/js/app.js', 'frontend/js')
    .js('src/admin/js/app.js', 'admin/js')
    .sass('src/frontend/sass/ltr_app.scss', 'frontend/css')
    .sass('src/frontend/sass/rtl_app.scss', 'frontend/css')
    .sass('src/admin/sass/ltr_app.scss', 'admin/css')
    .sass('src/admin/sass/rtl_app.scss', 'admin/css');
