const gulp = require('gulp');
const notify = require('gulp-notify');
const phpspec = require('gulp-phpspec');
const _ = require('lodash');

gulp.task('test', function() {
    gulp.src('spec/**/*.php')
        .pipe(phpspec('', {notify: true, clear: true}))
        .on('error', notify.onError(testNotification('fail', 'phpspec')))
        .pipe(notify(testNotification('pass', 'phpspec')));
});

function testNotification(status, pluginName, override) {
    let options = {
        title:   ( status === 'pass' ) ? 'Tests Passed!' : 'Tests Failed',
        message: ( status === 'pass' ) ? '\n\nAll tests have passed!\n\n' : '\n\nOne or more tests failed...\n\n',
        icon:    __dirname + '/node_modules/gulp-' + pluginName +'/assets/test-' + status + '.png'
    };
    options = _.merge(options, override);
    return options;
}

gulp.task('watch', function() {
    gulp.watch(['spec/**/*.php', 'src/**/*.php'], ['test']);
});

gulp.task('default', ['test', 'watch']);