<?php
define(PROJECT_DIR, C("PROJECT_DIR"));
define(PROJECT_DEV_DIR, C("PROJECT_DEV_DIR"));
define(PROJECT_NAME, C("PROJECT_NAME"));
define(PROJECT_DEV_NAME, C("PROJECT_DEV_NAME"));

/**
 * 根据插件名获取插件Service
 * @param $plugin_name
 * @return mixed
 */
function getPluginByName($plugin_name)
{
    $plugins = array(
        'Baidutongji' => new \Plugin\Plugins\Baidutongji\BaidutongjiPlugin()
        ,'ZhutibangCopyright' => new \Plugin\Plugins\ZhutibangCopyright\ZhutibangCopyrightPlugin()
        ,'Accesstime' => new \Plugin\Plugins\Accesstime\AccesstimePlugin()
        ,'Accessdomain' => new \Plugin\Plugins\Accessdomain\AccessdomainPlugin()
        ,'Wxuserinfo' => new \Plugin\Plugins\Wxuserinfo\WxuserinfoPlugin()
        , 'Bottombanner' => new \Plugin\Plugins\Bottombanner\BottombannerPlugin()
        , 'InterstitialAdv' => new \Plugin\Plugins\InterstitialAdv\InterstitialAdvPlugin()
    );

    return $plugins[$plugin_name];
}