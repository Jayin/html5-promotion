<?php
/**
 * Created by PhpStorm.
 * User: jayin
 * Date: 2/29/16
 * Time: 6:41 PM
 */

namespace Plugin\Service;


use Common\Lib\File;
use Home\Service\ProjectService;

/**
 * 插件相关服务
 * Class PluginService
 * @package Plugin\Service
 */
class PluginService {
    /**
     * 更新插件对应的input: regex
     * @param $project_name
     * @param $plugin_name
     * @param $plugin_input_name
     * @param $value
     */
    public static function updatePluginConfigRegex($project_name, $plugin_name, $plugin_input_name, $value) {
        $project_plugin_config = ProjectService::readProjectDevPluginConfig($project_name);
        $inputs = $project_plugin_config['config'][$plugin_name]['input'];
        foreach($inputs as $index => $input){
            if($plugin_input_name == $input['name']){
                $project_plugin_config['config'][$plugin_name]['input'][$index]['value'] = $value;
                File::write_file(C('PROJECT_DEV_DIR') . '/' . $project_name . '/' . C('PROJECT_PLUGIN_FILE'), json_encode($project_plugin_config));
                break;
            }
        }
    }

    /**
     * 替换文件内容
     * 由于每个插件的标识唯一的，所以不用做额外处理
     * @param $project_name
     * @param $file
     * @param $regex
     * @param $text
     */
    public static function updateText($project_name, $file, $regex, $text) {
        //目标文件替换
        $content = File::read_file(C('PROJECT_DEV_DIR') . '/' . $project_name . '/' . $file);
        $content = str_replace($regex, $text, $content);
        File::write_file(C('PROJECT_DEV_DIR') . '/' . $project_name . '/' . $file, $content);
    }
}
