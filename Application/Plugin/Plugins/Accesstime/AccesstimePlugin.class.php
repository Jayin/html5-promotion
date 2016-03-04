<?php

namespace Plugin\Plugins\Accesstime;


use Common\Lib\File;
use Home\Service\TemplateService;
use Plugin\Plugins\Plugin;

class AccesstimePlugin extends Plugin{
//    "Accesstime": {
//        "description": "访问时间",
//        "regex": "<!-- ACCESS_TIME -->",
//        "files": [
//            "index.php"
//        ],
//        "input": [
//            {
//                "name": "start_date",
//                "description": "开始日期(格式:年-月-日-时-分-秒)",
//                "type": "text"
//                },
//                {
//                    "name": "end_date",
//                    "description": "结束日期(格式:年-月-日-时-分-秒)",
//                    "type": "text"
//                }
//        ]
//    }

    function getContent() {
        $regexs = array();
        $replacements = array();

        $input_start_date = $this->getPluginInputByName('start_date');
        $input_end_date = $this->getPluginInputByName('end_date');
        $input_redirect = $this->getPluginInputByName('redirect');


        if(!$input_start_date['value'] || !$input_end_date['value']){
            //没有开始日期 or 结束日期
            return '';
        }
        $regexs = array_merge($regexs, array('__start_year__', '__start_month__', '__start_day__', '__start_hour__', '__start_minute__', '__start_second__'));
        $replacements = array_merge($replacements, explode('-', $input_start_date['value']));

        $regexs = array_merge($regexs, array('__end_year__', '__end_month__', '__end_day__', '__end_hour__', '__end_minute__', '__end_second__'));
        $replacements = array_merge($replacements, explode('-', $input_end_date['value']));

        $regexs[] = '__redirect__';
        $replacements[] = $input_redirect['value'];

        $content = File::read_file(__DIR__.'/main.php');
        return TemplateService::textReplace($content, $regexs, $replacements);
    }
}