'use strict'

const gulp = require('gulp')
const child_process = require('child_process')
const REMOTE = 'api.fenxiangbei.com'
const REMOTE_DIR = '/var/www/h5/html5-promotion'

let watchDir = [
  './Application/**/*',
  './Package/**/*',
  './Project/**/*',
  './Project_dev/**/*',
  './Public/**/*',
]

gulp.task('remote-sync', ()=>{
  // console.log(REMOTE+':'+REMOTE_DIR)
  try{
    child_process.execSync('rsync -r -P ./ root@'+REMOTE+':'+REMOTE_DIR)  
  }catch(err){
    console.log('sync faild🐶')
  }
  
})

gulp.task('watch', ()=>{
  gulp.watch(watchDir,['remote-sync'])
})

gulp.task('default', ['watch'])




