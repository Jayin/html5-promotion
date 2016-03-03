<?php
/**
 * Created by PhpStorm.
 * User: jayin
 * Date: 2/29/16
 * Time: 6:41 PM
 */

namespace Home\Service;


use Common\Lib\File;
use Home\Service\ProjectInfoConfigService;
use Home\Service\ProjectService;
use Home\Service\TemplateService;

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
        foreach ($inputs as $index => $input) {
            if ($plugin_input_name == $input['name']) {
                $project_plugin_config['config'][$plugin_name]['input'][$index]['value'] = $value;
                File::write_file(C('PROJECT_DEV_DIR') . '/' . $project_name . '/' . C('PROJECT_PLUGIN_FILE'), json_encode($project_plugin_config));
                break;
            }
        }
    }

    /**
     * 获取该项目需要修改文件$file相关的regex/value
     * @param $project_name
     * @return array
     */
    public static function getRegexAndValue($project_name) {
        $project_plugin_config = ProjectService::readProjectDevPluginConfig($project_name);
        $regexs = array();
        $replacements = array();
        foreach ($project_plugin_config['config'] as $plugin_name => $plugin_config) {
            //先渲染除当前要渲染的($regex)以外的Text
            $plugin = getPluginByName($plugin_name);
            $plugin->setPluginConfig($plugin_config);
            $value = $plugin->getContent();
            $regexs[] = $plugin_config['regex'];
            $replacements[] = $value;
        }

        return array('regexs' => $regexs, 'replacements' => $replacements);
    }
}
