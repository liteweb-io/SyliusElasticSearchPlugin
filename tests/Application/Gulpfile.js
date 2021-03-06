var gulp = require('gulp');
var chug = require('gulp-chug');
var argv = require('yargs').argv;

config = [
    '--rootPath',
    argv.rootPath || '../../../../../../../tests/Application/web/assets/',
    '--nodeModulesPath',
    argv.nodeModulesPath || '../../../../../../../tests/Application/node_modules/',
    '--vendorPath',
    argv.vendorPath || '../../../../../../../vendor/'
];

gulp.task('admin', function() {
    gulp.src('../../vendor/sylius/sylius/src/Sylius/Bundle/AdminBundle/gulpfile.babel.js.bak', { read: false })
        .pipe(chug({ args: config }))
    ;
});

gulp.task('shop', function() {
    gulp.src('../../vendor/sylius/sylius/src/Sylius/Bundle/ShopBundle/gulpfile.babel.js.bak', { read: false })
        .pipe(chug({ args: config }))
    ;
});

gulp.task('default', ['admin', 'shop']);
