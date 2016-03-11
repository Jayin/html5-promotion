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
     * 渲染项目下的模板文件(内容替换+插件配置)
     * @param $project_name
     * @param $file
     */
    public static function renderFile($project_name, $file){
        $project_info_config_regex_value = ProjectInfoConfigService::getFileRegexAndValue($project_name, $file);
        $plugin_config_regex_value = PluginService::getRegexAndValue($project_name);

        $content = TemplateService::fetchContent($project_name, $file, $project_info_config_regex_value, $plugin_config_regex_value);
        File::write_file(C('PROJECT_DEV_DIR') . '/' . $project_name . '/' . $file, $content);
    }

    /**
     * 更新配置文件
     * @param $project_name
     * @param $edit_page
     * @param $type
     * @param $regex
     * @param $text
     */
    public static function updateProjectInfoRegex($project_name, $edit_page, $type, $regex, $text) {
        //更新配置文件
        $project_info = self::readProjectDevInfoConfig($project_name);
        $configs = $project_info[$edit_page][$type];
        $targetIndex = 0;
        for ($index = 0; $index < count($configs); $index++) {
            if ($configs[$index]['regex'] === $regex) {
                $targetIndex = $index;
                $project_info[$edit_page][$type][$targetIndex]['value'] = $text;
                $json_string = json_encode($project_info);
                File::write_file(C('PROJECT_DEV_DIR') . '/' . $project_name . '/' . C('PROJECT_INFO_FILE'), $json_string);
                break;
            }
        }

    }

    /**
     * @param $project_name
     * @return bool
     */
    public static function package($project_name) {
        $create_date = date('YmdHis');
        $srcDir = C('PROJECT_DEV_DIR') . '/' . $project_name;
        $destDir = C('PROJECT_PACKAGE_DIR') . '/' . $project_name . '-' . $create_date;
        File::copy_dir($srcDir, $destDir);
        File::del_dir($destDir . '/.html5');
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

    /**
     * 读取Project plugin.json
     * @param $project_name
     * @return mixed
     */
    public static function readProjectDevPluginConfig($project_name) {
        return json_decode(File::read_file(C('PROJECT_DEV_DIR') . "/" . $project_name . "/" . C('PROJECT_PLUGIN_FILE')), 1);
    }

}
