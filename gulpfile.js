var gulp = require('gulp'),
    concat = require('gulp-concat'),
    sass   = require('gulp-sass'),
    //gzip = require('gulp-gzip'),
    cleanCSS = require('gulp-clean-css'),
    addsrc = require('gulp-add-src'),
    uglify = require('gulp-uglify'),
    inject = require('gulp-inject-string');

var scss_dir = './scss';
var css_dir  = './css';


var css_files = {
    home_css        : { outcome: 'home',  files : [
         /*scss_dir+'/'+'_common.scss',
        scss_dir+'/'+'_header.scss',
        scss_dir+'/'+'_menu.scss',
        scss_dir+'/'+'_footer.scss',*/
        scss_dir+'/'+'home.scss'
    ]},
    
    single_css      : { outcome:'single', files : [ 
        /*scss_dir+'/'+'_common.scss',
        scss_dir+'/'+'_header.scss',
        scss_dir+'/'+'_menu.scss',
        scss_dir+'/'+'_footer.scss',
        scss_dir+'/'+'_sidebar.scss',*/
        scss_dir+'/'+'single.scss' 
    ]},

    activities_css  : { outcome:'activities', files : [ 
        /*scss_dir+'/'+'_common.scss',
        scss_dir+'/'+'_header.scss',
        scss_dir+'/'+'_menu.scss',
        scss_dir+'/'+'_footer.scss',*/
        scss_dir+'/'+'activities.scss' 
    ]},
  
    teachers_css    : { outcome:'teachers', files : [
        /*scss_dir+'/'+'_common.scss',
        scss_dir+'/'+'_header.scss',
        scss_dir+'/'+'_menu.scss',
        scss_dir+'/'+'_footer.scss',*/
        scss_dir+'/'+'teachers.scss' 
    ]},
  
    cd_css          : { outcome:'cd', files : [
        /*scss_dir+'/'+'_common.scss',
        scss_dir+'/'+'_header.scss',
        scss_dir+'/'+'_menu.scss',
        scss_dir+'/'+'_footer.scss',*/
        scss_dir+'/'+'cd.scss' 
    ]},


};

var defaultTasks = [];

function createCssTask(page) {
  gulp.task(page, function(){
    return gulp.src(css_files[page].files)
           //.pipe(concat(css_files[page].outcome+'.scss'))
           .pipe(sass().on('error', sass.logError))
           .pipe(cleanCSS({debug: true}, function(details) {
              console.log(details.name + ': ' + details.stats.originalSize);
              console.log(details.name + ': ' + details.stats.minifiedSize);
           }))
           .pipe(addsrc.prepend('./libs/foundation/**/*.min.css'))
           .pipe(concat(css_files[page].outcome+'.css'))
           //.pipe(gzip())
           .pipe(gulp.dest(css_dir));
  });
}

for(page in css_files) {
    createCssTask(page);
    defaultTasks.push(page);
}


var jsdir = './libs/foundation/js/vendor/';

// elenco dei file per creare il javascript
var js_files = [jsdir+'jquery.js', 
                jsdir+'foundation.min.js',
                jsdir+'what-input.js',
                './js/jquery.cookiesdirective.js',
                './js/actions.js'];


// basic function
gulp.task('js', function(){
  return gulp.src(js_files)
         .pipe(concat('scripts.js'))
         .pipe(uglify())
         .pipe(gulp.dest('./js/'));
});

defaultTasks.push('js');


gulp.task('default', gulp.series(defaultTasks), function(){
    for (var page in css_files)
    {
        gulp.watch(scss_dir+'/*.scss', [page]);
    }
    gulp.watch(js_files, ['js']);
});
