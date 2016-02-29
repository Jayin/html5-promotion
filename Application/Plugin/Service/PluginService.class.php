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
     * @param $new_regex
     */
    public static function updatePluginConfigRegex($project_name, $plugin_name, $plugin_input_name, $new_regex) {
        $project_plugin_config = ProjectService::readProjectDevPluginConfig($project_name);
        $inputs = $project_plugin_config['config'][$plugin_name]['input'];
        foreach($inputs as $index => $input){
            if($plugin_input_name == $input['name']){
                $project_plugin_config['config'][$plugin_name]['input'][$index]['regex'] = $new_regex;
                File::write_file(C('PROJECT_DEV_DIR') . '/' . $project_name . '/' . C('PROJECT_PLUGIN_FILE'), json_encode($project_plugin_config));
                break;
            }
        }
    }
}