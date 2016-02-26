<?php

namespace Home\Service;

use Common\Lib\File;
use Common\Lib\Zip;

/**
 * Class ProjectService
 * @package Home\Service
 */
class ProjectService {

    public function __construct() {

    }

    //======== COMMON
    /**
     * 把h5项目从PROJECT_DIR复制到PROJECT_DEV_DIR
     * @param $project_name
     * @return bool
     */
    public static function projectCopyToDev($project_name) {
        return File::copy_dir(C('PROJECT_DIR') . "/" . $project_name, C('PROJECT_DEV_DIR') . "/" . $project_name);
    }

    /**
     * 替换文件内容
     * @param $project_name
     * @param $file
     * @param $regex
     * @param $text
     * @return bool
     */
    public static function updateText($project_name, $file, $regex, $text) {
        $content = File::read_file(C('PROJECT_DEV_DIR') . '/' . $project_name . '/' . $file);
        $content = str_replace($regex, $text, $content);
        return File::write_file(C('PROJECT_DEV_DIR') . '/' . $project_name . '/' . $file, $content);
    }

    /**
     * @param $project_name
     * @return bool
     */
    public static function package($project_name) {
        $create_date = date('YmdHis');
        File::copy_dir(C('PROJECT_DEV_DIR') . '/' . $project_name, C('PROJECT_PACKAGE_DIR') . '/' . $project_name . '-' . $create_date);
        Zip::pack(C('PROJECT_DEV_DIR') . '/' . $project_name, C('PROJECT_PACKAGE_DIR') . '/' . $project_name . '-' . $create_date . '.zip');
    }

    /**
     * 删除打包项目
     * @param $project_name
     */
    public static function deletePackProject($project_name) {
        File::del_dir(C('PROJECT_PACKAGE_DIR') . '/' . $project_name);
        File::del_file(C('PROJECT_PACKAGE_DIR') . '/' . $project_name . '.zip');
    }

    //======== Project

    /**
     * 判断项目是否存在于PROJECT_DIR下
     * @param $project_name
     * @return bool
     */
    public static function projectExist($project_name) {
        if (ProjectService::readProjectConfig($project_name)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取Project config配置
     * @param $project_name
     * @return json
     */
    public static function readProjectConfig($project_name) {
        return json_decode(File::read_file(C('PROJECT_DIR') . "/" . $project_name . "/" . C('PROJECT_CONFIG_FILE')), 1);
    }

    /**
     * 获取Project info配置
     * @param $project_name
     * @return json
     */
    public static function readProjectInfoConfig($project_name) {
        return json_decode(File::read_file(C('PROJECT_DIR') . "/" . $project_name . "/" . C('PROJECT_INFO_FILE')), 1);
    }

    //===============Project DEV

    /**
     * 判断项目是否存在于PROJECT_DEV_DIR下
     * @param $project_name
     * @return bool
     */
    public static function projectDevtExist($project_name) {
        if (ProjectService::readProjectDevConfig($project_name)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取Project DEV config配置
     * @param $project_name
     * @return json
     */
    public static function readProjectDevConfig($project_name) {
        return json_decode(File::read_file(C('PROJECT_DEV_DIR') . "/" . $project_name . "/" . C('PROJECT_CONFIG_FILE')), 1);
    }

    /**
     * 获取Project DEV info配置
     * @param $project_name
     * @return json
     */
    public static function readProjectDevInfoConfig($project_name) {
        return json_decode(File::read_file(C('PROJECT_DEV_DIR') . "/" . $project_name . "/" . C('PROJECT_INFO_FILE')), 1);
    }

}
