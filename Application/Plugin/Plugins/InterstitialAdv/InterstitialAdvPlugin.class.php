<?php

// +----------------------------------------------------------------------
// | Jifen 
// +----------------------------------------------------------------------
// | Copyright (c) Zhutibag.Inc 2016 http://zhutibang.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: Jayin Ton <tonjayin@gmail.com>
// +----------------------------------------------------------------------

namespace Plugin\Plugins\InterstitialAdv;


use Common\Lib\File;
use Home\Service\TemplateService;
use Plugin\Plugins\Plugin;

class InterstitialAdvPlugin extends Plugin{

//"InterstitialAdv": {
//    "description": "开屏时弹出关注二维码",
//    "regex": "<!-- INTERSTITIAL_ADV -->",
//    "files": [
//        "index.php"
//    ],
//    "input": [
//        {
//            "name": "enable",
//            "description": "是否显示弹框",
//            "type": "radio"
//        },
//
//            {
//                "name": "img_url",
//                    "description": "关注二维码图片链接(建议100px * 100px)",
//                    "type": "text",
//                    "value": "http://ww1.sinaimg.cn/large/6ee3e8b3gw1f2208yladdj202s02sq2v.jpg"
//                  },
//            {
//                "name": "关注二维码文案",
//                    "description": "点击跳转链接",
//                    "type": "text",
//                    "value": "长按二维码，关注主题邦公众号 <br>发现更多好玩的H5"
//                  }
//        ]
//}

    /**
     * 获取渲染配置后的内容
     *
     * @return mixed
     */
    function getContent() {
        $input_enable = $this->getPluginInputByName('enable');
        $input_img_url = $this->getPluginInputByName('img_url');
        $input_content = $this->getPluginInputByName('content');
        if(!$input_enable['value']){
            return '';
        }
        return TemplateService::textReplace(File::read_file(__DIR__ . '/main.html'), array('__IMG_URL__', '__CONTENT__'), array($input_img_url['value'], $input_content['value']));
    }
}