# Roots child theme generator

Version: 1.0.0-alpha

A [Yeoman](http://yeoman.io) generator for scaffolding a custom [Roots](https://github.com/roots/roots) child theme.

## Contributors

Duane Cilliers ( [@duanecilliers](https://twitter.com/duanecilliers) / [signpost.co.za](http://www.signpost.co.za) / [duane.co.za](http://duane.co.za) )


## Summary

A [Roots](https://github.com/roots/roots) child theme for WordPress. Dequeues Roots styles and scripts and uses Compass/SCSS with Sass-Bootstrap and Grunt for all tasks.

## Features

* All the benefits of Roots
* Choose between Sass Bootstrap, LESS Bootsrap or no CSS pre-processor (enqueues minified Bootstrap).
* [LiveReload](http://livereload.com/) the browser (with extension)
* CSS Autoprefixing
* Automatically compile Compass/Sass/Less
* Automatically lint, concatenate and minify your JavaScript (with source maps)
* Automatically version your styles and scripts with an md5 hash
* Awesome Image Optimization (via OptiPNG, pngquant, jpegtran and gifsicle)
* Optional - Leaner Modernizr builds
* Deploy your theme via Rsync

## Usage

* Clone the repo`git clone https://github.com/duanecilliers/Generator-Roots-Child.git`
* Run `npm link` to symlink to your ENV PATH. (Publishing as a NPM package soon!)
* Run `yo roots-child` inside an empty theme directory
* Run `grunt` for building and `grunt dev` for watching and compiling
* Make sure you have [Roots](https://github.com/roots/roots) (the parent theme) installed

## Bower

Supports [bower](https://github.com/bower/bower) to install and manage dependencies in the bower_components folder.

## FAQs

* Why are no styles reflecting?
    * If the 'WP_DEV_MODE' constant is set to true, be sure to run `$ grunt dev` to watch and compile changes.
    If 'WP_DEV_MODE' is not set or is false, minified assets are enqueued, so be sure to run `$ grunt` which compiles and minfies CSS and JavaScript. While developing, I suggest adding `define( 'WP_DEV_MODE', true )` to wp-config.php.

## TODOs

* Consider deployment config prompts

## License

[MIT License](http://en.wikipedia.org/wiki/MIT_License)
