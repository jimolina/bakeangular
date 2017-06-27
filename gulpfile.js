var gulp        = require('gulp');
var browserSync = require('browser-sync').create();

// Reloading browsers
// this taks will be execute after a change on any .css file
gulp.task('css-watch', function () {
    browserSync.reload();
});

gulp.task('default', function () {
    // Start the Browser Server
    browserSync.init({ });

    // call the task 'css-watch'
    gulp.watch("webroot/css/*.css", ['css-watch']);
});