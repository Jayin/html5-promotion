'use strict'

const gulp = require('gulp')
const child_process = require('child_process')

let watchDir = [
  './Application/**/*',
  './Package/**/*',
  './Project/**/*',
  './Project_dev/**/*',
  './Public/**/*',
]

gulp.task('remote-sync', ()=>{
  child_process.execSync('rsync -r -P ./ root@api.fenxiangbei.com:/var/www/h5/html5-promotion')
})

gulp.task('watch', ()=>{
  gulp.watch(watchDir,['remote-sync'])
})

gulp.task('default', ['watch'])




