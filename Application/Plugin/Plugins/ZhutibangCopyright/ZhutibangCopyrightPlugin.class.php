<?php
/**
 * Created by PhpStorm.
 * User: jayin
 * Date: 3/2/16
 * Time: 3:47 PM
 */

namespace Plugin\Plugins\ZhutibangCopyright;


use Common\Lib\File;
use Plugin\Plugins\Plugin;

class ZhutibangCopyrightPlugin extends Plugin {

//"ZhutibangCopyright": {
//    "description": "\u4e3b\u9898\u90a6\u7248\u6743\u4fe1\u606f",
//    "regex": "<!-- ZHUTIBANG_COPYRIGHT -->",
//    "input": [
//        {
//        "name": "copyright_show",
//        "description": "\u662f\u5426\u663e\u793a\u4e3b\u9898\u90a6\u7248\u6743\u4fe1\u606f",
//        "type": "radio",
//            "files": [
//                "input.php"
//            ]
//        }
//    ]
//}

    private $tpl = 'default.tag.html';

    function getContent() {
        $config = $this->getPluginConfig();
        if (isset($config['input'][0]['value']) && $config['input'][0]['value'] == '1') {
            return File::read_file(dirname(__FILE__) . '/' . $this->tpl);
        }
        return '';

    }
}
