<?php

namespace Home\Service;

use Common\Lib\File;

/**
 * Class ProjectService
 * @package Home\Service
 */
class ProjectService {

    public function __construct() {

    }

    //======== COMMON

    public static function projectCopyToDev($project_name) {
        File::copy_dir(C('PROJECT_DIR') . "/" . $project_name, C('PROJECT_DEV_DIR') . "/" . $project_name);
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
        return json_decode(File::read_file(C('PROJECT_DEV_DIR') . "/" . $project_name . "/" . self::PROJECT_CONFIG_FILE), 1);
    }

    /**
     * 获取Project DEV info配置
     * @param $project_name
     * @return json
     */
    public static function readProjectDevInfoConfig($project_name) {
        return json_decode(File::read_file(C('PROJECT_DEV_DIR') . "/" . $project_name . "/" . self::PROJECT_INFO_FILE), 1);
    }

}
