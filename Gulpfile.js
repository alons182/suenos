var gulp        = require('gulp'),
    uglify      = require('gulp-uglify'),
    stripDebug  = require('gulp-strip-debug'),
    minifyCSS   = require('gulp-minify-css'),
    stylus      = require('gulp-stylus'),
    nib         = require('nib'),
    concat      = require('gulp-concat');


gulp.task('js', function () {
  gulp.src([
    './assets/js/vendor/jquery-1.11.0.min.js',
    './assets/js/vendor/jquery.hoverIntent.minified.js',
    './assets/js/vendor/holder.js',
    './assets/js/vendor/easyzoom.js',
    './assets/js/vendor/legacy.js',
    './assets/js/vendor/picker.js',
    './assets/js/vendor/picker.date.js',
    './assets/js/vendor/simpleCart.min.js',
    './assets/js/vendor/jquery.cycle2.min.js',
    './assets/js/main.js'
   
    ])
    //.pipe(browserify())
    .pipe(uglify({ compress: true }))
    //.pipe(stripDebug())
    .pipe(concat('bundle.js'))
    .pipe(gulp.dest('./public/js'));
 
});

// Get and render all .styl files recursively
gulp.task('stylus', function () {
  gulp.src('./assets/stylus/main.styl')
    .pipe(stylus({use: [nib()]}))
    .pipe(gulp.dest('./assets/css/'));
});

gulp.task('css', function () {
  gulp.src(['./assets/css/main.css','./assets/css/default.css','./assets/css/default.date.css'])
    .pipe(minifyCSS({ keepSpecialComments: '*', keepBreaks: '*'}))
    .pipe(concat('bundle.css'))
    .pipe(gulp.dest('./public/css'));
});

gulp.task('js_admin', function () {
    gulp.src([
        './assets/js/vendor/jquery-1.11.0.min.js',
        './assets/js/vendor/handlebars-v1.3.0.js',
        './assets/js/vendor/lightbox.min.js',
        './assets/js/vendor/ajaxupload.js',
        './assets/js/vendor/colpick.js',
        './assets/js/vendor/holder.js',
        './assets/js/vendor/legacy.js',
        './assets/js/vendor/picker.js',
        './assets/js/vendor/picker.date.js',



        './assets/js/admin.js'

    ])
        //.pipe(browserify())
        .pipe(uglify({ compress: true }))
        .pipe(stripDebug())
        .pipe(concat('bundle_admin.js'))
        .pipe(gulp.dest('./public/js'));

});
gulp.task('css_admin', function () {
    gulp.src(['./assets/css/lightbox.css','./assets/css/colpick.css','./assets/css/admin.css','./assets/css/classic.css','./assets/css/classic.date.css'])
        .pipe(minifyCSS({ keepSpecialComments: '*', keepBreaks: '*'}))
        .pipe(concat('bundle_admin.css'))
        .pipe(gulp.dest('./public/css'));
});

gulp.task('watch', function () {
    gulp.watch(['./assets/js/**/*.js'],['js','js_admin']);
    gulp.watch(['./assets/stylus/**/*.styl'],['stylus']);
    gulp.watch(['./assets/css/**/*.css'],['css','css_admin']);
   
});

gulp.task('default', [ 'js','stylus','css','js_admin','css_admin', 'watch' ]);
