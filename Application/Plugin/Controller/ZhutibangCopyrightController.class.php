<?php
/**
 * Created by PhpStorm.
 * User: jayin
 * Date: 3/2/16
 * Time: 10:12 AM
 */

namespace Plugin\Controller;

use Common\Controller\PluginController;

use Home\Service\ProjectService;
use Plugin\Plugins\Baidutongji\BaidutongjiPlugin;

use Plugin\Plugins\ZhutibangCopyright\ZhutibangCopyrightPlugin;
use Plugin\Service\PluginService;

class ZhutibangCopyrightController extends PluginController{

    public function index(){
        $result = PluginService::getRegexAndValue('yimiao');
        var_dump($result);
    }

    const YES = '1';
    const NO = '0';

    public function update() {
        $project_name = I('post.project_name');
        $plugin_name = I('post.plugin_name');
        $plugin_input_name = I('post.plugin_input_name');
        $value = I('post.value');

        if (!$project_name || !$plugin_name || !$plugin_input_name) {
            $this->error("请检查参数");
            return;
        }
        $project_plugin_config = ProjectService::readProjectDevPluginConfig($project_name);
        $plugin_config = $project_plugin_config['config'][$plugin_name];
        $plugin_input = null;
        foreach ($plugin_config['input'] as $index => $input) {
            if ($input['name'] == $plugin_input_name) {
                $plugin_input = $input;
                $plugin_config['input'][$index]['value'] = $value;
                break;
            }
        }
        if (!$plugin_input) {
            $this->error("找不到配置");
            return;
        }

        foreach ($plugin_input['files'] as $index => $file) {
            $plugin = new ZhutibangCopyrightPlugin();
            $plugin->setPluginConfig($plugin_config);
            PluginService::updateText($project_name, $file, $plugin_config['regex'], $plugin->getContent());
            PluginService::updatePluginConfigRegex($project_name, $plugin_name, $plugin_input_name, $value); //输入什么 就是什么值，最终$plugin_input的值取决于各个$value的统计方式

        }
        $this->success('更新成功');
    }

}