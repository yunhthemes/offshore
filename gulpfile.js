/* File: gulpfile.js */

// grab our gulp packages
var gulp  = require('gulp'),
    gutil = require('gulp-util'),
    elixir = require('laravel-elixir');

elixir.config.production = true;

// task that just log a message
gulp.task('log', function() {
  return gutil.log('Gulp is running!')
});

const imagemin = require('gulp-imagemin');

// auto optimize images
// gulp.task('default', () =>
    // gulp.src('wp-content/uploads/2016/01/*')
    //     .pipe(imagemin())
    //     .pipe(gulp.dest('wp-content/uploads/2016/01/dist'))

    // gulp.src('wp-content/uploads/2016/02/*')
    //     .pipe(imagemin())
    //     .pipe(gulp.dest('wp-content/uploads/2016/02/dist'))  
// );

elixir(function(mix) {
	mix.task('log');
    mix.scripts([
    	'./wp-content/themes/manic-offshore-theme/js/plugins/handlebars-v4.0.5.js', 
    	'./wp-content/themes/manic-offshore-theme/js/plugins/intlTelInput.min.js',
    	], './wp-content/themes/manic-offshore-theme/js/dist/manic-third-party.js');
    // mix.less(['./assets/css/less/style.less'], './dist/css/style.css');
});