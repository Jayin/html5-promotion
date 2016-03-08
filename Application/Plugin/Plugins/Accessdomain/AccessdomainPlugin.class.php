<?php
/**
 * Created by PhpStorm.
 * User: jayin
 * Date: 3/7/16
 * Time: 8:58 PM
 */

namespace Plugin\Plugins\Accessdomain;


use Common\Lib\File;
use Plugin\Plugins\Plugin;

class AccessdomainPlugin extends Plugin{
    //"Accessdomain": {
    //    "description": "指定可访问的域名",
    //    "regex": "<!-- ACCESS_DOMAIN -->",
    //    "files": [
    //        "index.php"
    //    ],
    //    "input": [
    //        {
    //            "name": "domains",
    //            "description": "可访问的域名，多个时用英文逗号(,)隔开",
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
        $input_domains = $this->getPluginInputByName('domains');
        $data = array(
            'domains' => array()
        );
        if(isset($input_domains['value'])){
            $domains = explode(',', strtolower($input_domains['value']));

            $data['domains'] = $domains;
        }
        $this->copyResource();
        $this->saveProjectDataJSON($data);

        return File::read_file(__DIR__.'/main.php');
    }
}