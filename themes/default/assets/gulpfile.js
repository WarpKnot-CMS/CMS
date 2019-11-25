const gulp = require('gulp');
const sass = require('gulp-sass');
const browserSync = require('browser-sync').create();
const jshint = require('gulp-jshint');
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const cssnano = require('gulp-cssnano');

let bases = {
        app: 'sources/',
        dist: '../dist/',
        fonts: 'fonts/',
        root: '../../'
    },
    paths = {
        scripts: [
            'js/custom.js',
            'js/../../../../../module/**/template/sources/js/*',
            'js/_plugins/*.js'
        ],
        libs: [
            '../../node_modules/jquery/dist/jquery.js',
            '../../sources/libraries/jQuery-Rebox/jquery-rebox.js',
            '../../node_modules/popper.js/dist/umd/popper.js',
            '../../node_modules/bootstrap/dist/js/bootstrap.js',
            '../../node_modules/blueimp-file-upload/js/vendor/jquery.ui.widget.js',
            '../../node_modules/blueimp-file-upload/js/jquery.fileupload.js'
        ],
        styles: [
            'scss/index.scss',
            'scss/../../../../../module/**/template/sources/scss/*'
        ],
        _views: [],
        fonts: ['fonts/**/*', '!libs/**/*'],
        images: ['images/**/*.*'],
        extras: ['crossdomain.xml', 'humans.txt', 'manifest.appcache', 'robots.txt', 'favicon.ico'],
    };

// Custom js scripts minify
gulp.task('scripts', function () {
    return gulp.src(paths.scripts, {cwd: bases.app})
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(uglify().on('error', function (e) {
        }))
        .pipe(concat('script.js'))
        .pipe(gulp.dest(bases.dist + 'scripts/'));
});

// Js libraries combine
gulp.task('scripts_lib', function () {
    // Concat lib scripts
    return gulp.src(paths.libs, {cwd: 'sources/**'})
        .pipe(uglify({output: {max_line_len: 120000}}))
        .pipe(concat('lib.js'))
        .pipe(gulp.dest(bases.dist + 'scripts/'));
});

// CSS Combine and minify
gulp.task('styles', function () {
    return gulp.src(paths.styles, {cwd: bases.app})
        .pipe(sass().on('error', sass.logError))
        .pipe(cssnano({
            discardComments: {removeAll: true}
        }))
        .pipe(concat('main.css'))
        .pipe(gulp.dest(bases.dist + 'styles/'));
});

// Images Minify and copy
gulp.task('imagemin', function () {
    return gulp.src(paths.images, {cwd: bases.app})
        .pipe(gulp.dest(bases.dist + 'images/'));
});

// Fonts copy
gulp.task('fonts', function () {
    return gulp.src(paths.fonts, {cwd: 'sources/**'}).pipe(gulp.dest(bases.dist));
});

// Gulp Watch Task
gulp.task('watch', function () {
    gulp.watch('../../../module/**/template/sources/**/*', gulp.series('scripts', 'styles', 'reload'));
    gulp.watch('sources/**/*', gulp.series('scripts', 'styles', 'reload'));
});

// Gulp Build Task
gulp.task('build', gulp.parallel('scripts', 'scripts_lib', 'styles', 'imagemin', 'fonts'));

// Browser Sync
gulp.task('browserSyncInit', function () {
    browserSync.init({
        port: 3333
    });
});

gulp.task('reload', function (done) {
    browserSync.reload({});
    done();
});

gulp.task('default', gulp.parallel('browserSyncInit', 'watch'));