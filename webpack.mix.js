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
mix.setPublicPath('../public_html/grid')
	.copyDirectory('resources/assets', '../public_html/grid/assets')
	.copyDirectory('resources/root', '../public_html/grid')
	.js('resources/js/app.js', 'js')
	.js('resources/js/settings.js', 'js')
	.js('resources/js/vue.js', 'js')
	.js('resources/js/stats.js', 'js')
	.sass('resources/sass/app.scss', 'css')
	.sass('resources/sass/vue.scss', 'css')
	.sass('resources/sass/custom.scss', 'css')
	.version();