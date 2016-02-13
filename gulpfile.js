var gulp    = require('gulp');
var concat  = require('gulp-concat');
var uglify  = require('gulp-uglify');
var watch   = require('gulp-watch');
var babel = require('gulp-babel');

var js_vendor = [
    'node_modules/jquery/dist/jquery.js',
    'node_modules/bootstrap/dist/js/bootstrap.js'
];

var js_custom = [
    'src/AppBundle/Resources/public/js/**/*.js',
]

gulp.task('vendor', function() {
    gulp.src(js_vendor)
        .pipe(concat('vendor.js'))
        .pipe(gulp.dest('web/js'));

    gulp.src('node_modules/bootstrap/dist/css/bootstrap.min.css')
        .pipe(gulp.dest('web/css'));

    return;
});

gulp.task('default', function() {
    return gulp.src(js_custom)
        .pipe(concat('app.js'))
        .pipe(gulp.dest('web/js'))
        .pipe(babel({
            presets: ['es2015']
        }))
        .pipe(gulp.dest('web/js'));
});

gulp.task('watch', ['default'], function () {
    gulp.watch(['./src/AppBundle/Resources/public/js/**/*.js'], ['default']);
});
