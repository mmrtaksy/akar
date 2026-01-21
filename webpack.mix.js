const mix = require('laravel-mix');


mix.setResourceRoot(process.env.ASSET_URL);
mix.setPublicPath('public');

mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
       require('tailwindcss'),
   ])
   .version();

