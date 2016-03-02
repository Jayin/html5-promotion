<?php
/**
 * Created by PhpStorm.
 * User: jayin
 * Date: 3/2/16
 * Time: 1:20 PM
 */

namespace Home\Service;


class ProjectInfoConfigService {
    /**
     * 获取该项目需要修改文件$file相关的regex/value
     * @param $project_name
     * @param $file
     * @return array
     */
    public static function getFileRegexAndValue($project_name, $file) {
        $project_info = ProjectService::readProjectDevInfoConfig($project_name);
        $regexs = array();
        $replacements = array();
        foreach ($project_info as $index => $edit_page_config) {
            //先渲染除当前要渲染的($regex)以外的Text
            $edit_page_texts_config = $edit_page_config['texts'];
            foreach ($edit_page_texts_config as $index => $text_config) {
                if (is_int(array_search($file, $text_config['files'])) && array_search($file, $text_config['files']) >= 0) {
                    //没有value则其值与regex相等
                    $value = isset($text_config['value']) ? $text_config['value'] : $text_config['regex'];
                    $regexs[] = $text_config['regex'];
                    $replacements[] = $value;
                }
            }
        }

        return array('regexs' => $regexs, 'replacements' => $replacements);
    }
}