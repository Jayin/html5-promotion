<?php
/**
 * Created by PhpStorm.
 * User: jayin
 * Date: 3/2/16
 * Time: 10:52 AM
 */

namespace Home\Service;


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

}
