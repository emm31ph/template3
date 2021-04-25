const mix = require('laravel-mix');
const path = require('path')

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

mix.js('resources/js/app.js', 'public/dist/js')
    .sass('resources/sass/app.scss', 'public/dist/css');


mix.disableNotifications();



if (mix.inProduction()) {
    mix
    // .extract() // Disabled until resolved: https://github.com/JeffreyWay/laravel-mix/issues/1889
    // .version() // Use `laravel-mix-versionhash` for the generating correct Laravel Mix manifest file.
        .versionHash()
} else {
    mix.sourceMaps()
}


const fs = require('fs');
const buildDir = './public/dist/js/';
fs.readdir(path.resolve(buildDir), (err, files) => {
    if (err) {
        console.log(err);
    } else {
        files.forEach(function(file) {
            fs.unlink(path.resolve(buildDir + file), function() {
                console.log(buildDir + file + ' - deleted');
            });
        });
    }
});



mix.webpackConfig({
    plugins: [

    ],
    resolve: {
        extensions: ['.js', '.json', '.vue'],
        alias: {
            '~': path.join(__dirname, './resources/js')
        }
    },
    output: {
        chunkFilename: 'dist/js/[chunkhash].js',
        path: mix.config.hmr ?
            '/' : path.resolve(__dirname, mix.inProduction() ? './public/build' : './public')
    },
})

mix.then(() => {
    if (mix.inProduction()) {
        process.nextTick(() => publishAseets())
    }
})

function publishAseets() {
    const publicDir = path.resolve(__dirname, './public')

    fs.removeSync(path.join(publicDir, 'dist'))
    fs.copySync(path.join(publicDir, 'build', 'dist'), path.join(publicDir, 'dist'))
    fs.removeSync(path.join(publicDir, 'build'))
}