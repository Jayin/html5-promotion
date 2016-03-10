<?php

namespace Plugin\Plugins\Bottombanner;


use Common\Lib\File;
use Plugin\Plugins\Plugin;

class BottombannerPlugin extends Plugin{

//"Bottombanner": {
//    "description": "获取授权的微信用户的信息",
//    "regex": "<!-- BOTTOM_BANNER -->",
//    "files": [
//        "index.php"
//    ],
//    "input": [
//        {
//            "name": "enable",
//            "description": "是否显示底部Banner图",
//            "type": "radio"
//        },
//        {
//            "name": "link",
//            "description": "点击跳转链接",
//            "type": "text"
//        },
//        {
//            "name": "img_url",
//            "description": "图片链接",
//            "type": "text"
//        }
//    ]
//}

    /**
     * 获取渲染配置后的内容
     *
     * @return mixed
     */
    function getContent() {
        $input_enable = $this->getPluginInputByName('enable');
        $input_link = $this->getPluginInputByName('link');
        $input_img_url = $this->getPluginInputByName('img_url');
        if(!$input_enable['value']){
            return '';
        }
        $link = $input_link['value'];
        $img_url = $input_img_url['value'];
        $content = File::read_file(__DIR__ . '/main.html');
        $content = str_replace('__LINK__', $link, $content);
        $content = str_replace('__IMG_URL__', $img_url, $content);

        return $content;
    }
}