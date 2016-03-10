<?php

namespace Plugin\Plugins\Wxuserinfo;


use Common\Lib\File;
use Plugin\Plugins\Plugin;

class WxuserinfoPlugin extends Plugin {

//"Wxuserinfo": {
//    "description": "获取授权的微信用户的信息",
//    "regex": "<!-- WX_USER_INFO -->",
//    "files": [
//    "index.php"
//    ],
//    "input": [
//        {
//            "name": "enable",
//            "description": "是否开启获取授权的微信用户信息",
//            "type": "radio" //0=NO or 1=yes
//        },
//        {
//            "name": "appid",
//            "description": "AppID(应用ID)",
//            "type": "text"
//          },{
//            "name": "appsecret",
//            "description": "AppSecret(应用密钥)",
//            "type": "text"
//          }
//    ]
//}
    /**
     * 获取渲染配置后的内容
     *
     * @return mixed
     */
    function getContent() {
        $input_enable = $this->getPluginInputByName('enable');
        $input_appid = $this->getPluginInputByName('appid');
        $input_appsecret = $this->getPluginInputByName('appsecret');
        if (!$input_enable['value']) {
            return '';
        }
        $data = array(
            'appid' => $input_appid['value'],
            'appsecret' => $input_appsecret['value']
        );
        $this->copyResource();
        $this->saveProjectDataJSON($data);

        return File::read_file(__DIR__ . '/main.php');
    }
}