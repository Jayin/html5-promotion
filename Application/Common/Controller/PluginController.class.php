<?php
/**
 * Created by PhpStorm.
 * User: jayin
 * Date: 2/29/16
 * Time: 5:57 PM
 */

namespace Common\Controller;


use Think\Controller;
use Home\Service\PluginService;
use Home\Service\ProjectService;

class PluginController extends Controller {

    public function update() {
        $project_name = I('post.project_name');
        $plugin_name = I('post.plugin_name');
        $plugin_input_names = I('post.plugin_input_names');
        $values = array();
        foreach ($plugin_input_names as $index => $plugin_input_name) {
            $values[] = I('post.value_' . $plugin_input_name, '', '');
        }

        if (!$project_name || !$plugin_name || !$plugin_input_names) {
            $this->error("请检查参数");

            return;
        }
        $project_plugin_config = ProjectService::readProjectDevPluginConfig($project_name);
        $plugin_config = $project_plugin_config['config'][$plugin_name];

        foreach ($plugin_config['files'] as $index => $file) {
            //更新配置后再渲染
            PluginService::batchUpdatePluginConfigRegex($project_name, $plugin_name, $plugin_input_names, $values);
            ProjectService::renderFile($project_name, $file);
        }
        $this->success('更新成功');
    }

}