<?php
/**
 * Created by PhpStorm.
 * User: jayin
 * Date: 2/29/16
 * Time: 5:58 PM
 */

namespace Plugin\Controller;


use Common\Controller\PluginController;
use Home\Service\PluginService;
use Home\Service\ProjectService;
use Plugin\Plugins\Baidutongji\BaidutongjiPlugin;


/**
 * 百度统计插件
 * Class BaidutongjiController
 * @package Plugin\Controller
 */
class BaidutongjiController extends PluginController {
    /**
     * 更新百度统计配置
     */
    public function update() {
        $project_name = I('post.project_name');
        $plugin_name = I('post.plugin_name');
        $plugin_input_name = I('post.plugin_input_name');
        $value = I('post.value', '', '');//允许脚本？

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

        foreach ($plugin_config['files'] as $index => $file) {
            $plugin = new BaidutongjiPlugin();
            $plugin->setPluginConfig($plugin_config);

            PluginService::updateText($project_name, $file, $plugin_config['regex'], $plugin->getContent());
            PluginService::updatePluginConfigRegex($project_name, $plugin_name, $plugin_input_name, $value);

        }
        $this->success('更新成功');
    }
}
