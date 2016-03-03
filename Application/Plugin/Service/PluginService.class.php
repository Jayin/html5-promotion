<?php
/**
 * Created by PhpStorm.
 * User: jayin
 * Date: 2/29/16
 * Time: 6:41 PM
 */

namespace Plugin\Service;


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
     * 替换文件内容
     * 由于每个插件的标识唯一的，所以不用做额外处理
     * @param $project_name
     * @param $file
     * @param $regex
     * @param $text
     */
    public static function updateText($project_name, $file, $regex, $text) {
        //目标文件替换
        $project_info_config_regex_value = ProjectInfoConfigService::getFileRegexAndValue($project_name, $file);
        $plugin_config_regex_value = self::getRegexAndValue($project_name);
        $targetIndex = -1;
        foreach($plugin_config_regex_value['regexs'] as $index => $plugin_config_regex){
            if($plugin_config_regex === $regex){
                $targetIndex = $index;
                break;
            }
        }
        //if found
        if($targetIndex >= 0){
            array_splice($plugin_config_regex_value['regexs'], $targetIndex, 1);
            array_splice($plugin_config_regex_value['replacements'], $targetIndex, 1);

            $content = TemplateService::fetchContent($project_name, $file, $project_info_config_regex_value, $plugin_config_regex_value);
            $content = TemplateService::textReplace($content, array($regex), array($text));
            File::write_file(C('PROJECT_DEV_DIR') . '/' . $project_name . '/' . $file, $content);

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
