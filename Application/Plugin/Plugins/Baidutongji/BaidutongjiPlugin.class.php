<?php
/**
 * Created by PhpStorm.
 * User: jayin
 * Date: 3/2/16
 * Time: 5:17 PM
 */

namespace Plugin\Plugins\Baidutongji;

use Plugin\Plugins\Plugin;

class BaidutongjiPlugin extends Plugin{

//    "Baidutongji": {
//            "description": "百度统计插件",
//            "regex": "<!-- BAIDU_TONGJI -->",
//            "input": [
//                {
//                    "name": "baidu_tongji_code",
//                    "description": "百度统计代码",
//                    "type": "text",
//                    "files": [
//                        "index.php"
//                    ]
//                }
//            ]
//        },


    function getContent() {
        $this->plugin_config['input'][0];
        $value = $this->plugin_config['input'][0]['value'];
        if($value){
            return $value;
        }
        return '';
    }
}