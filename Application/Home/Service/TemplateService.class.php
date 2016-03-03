<?php
/**
 * Created by PhpStorm.
 * User: jayin
 * Date: 3/2/16
 * Time: 10:52 AM
 */

namespace Home\Service;


use Common\Lib\File;
use Plugin\Service\PluginService;

class TemplateService {

    /**
     * 文本替换
     * @param string $content 内容
     * @param array $regexs 匹配项列表
     * @param array $replacements 替换内容列表
     * @return string 替换后的内容
     */
    public static function textReplace($content, $regexs, $replacements) {

        foreach ($regexs as $index => $regex) {
            $content = str_replace($regex, $replacements[$index], $content);
        }

        return $content;
    }

    /**
     * 根据给定的info config和plugin config 去渲染模板
     * @param $project_name
     * @param $file
     * @param array $info_config project config's regexs/replacement
     * @param array $plugin_config plugin config's regexs/replacement
     * @return string
     */
    public static function fetchContent($project_name, $file, $info_config = array('regexs' => array(), 'replacements' => array()), $plugin_config = array('regexs' => array(), 'replacements' => array())) {
        $content = File::read_file(C('PROJECT_DIR') . '/' . $project_name . '/' . $file);
        $content = self::textReplace($content, $info_config['regexs'], $info_config['replacements']);
        $content = self::textReplace($content, $plugin_config['regexs'], $plugin_config['replacements']);

        return $content;
    }

}
