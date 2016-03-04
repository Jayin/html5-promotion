<?php
/**
 * Created by PhpStorm.
 * User: jayin
 * Date: 3/2/16
 * Time: 3:57 PM
 */

namespace Plugin\Plugins;


abstract class Plugin {

    protected $plugin_config;

    /**
     * @return mixed
     */
    public function getPluginConfig() {
        return $this->plugin_config;
    }

    /**
     * @param mixed $plugin_config
     */
    public function setPluginConfig($plugin_config) {
        $this->plugin_config = $plugin_config;
    }

    /**
     * 获取渲染配置后的内容
     * @return mixed
     */
    abstract function getContent();

    /**
     * 根据input name获取对应plugin 的input选项config
     * @param $input_name
     * @return null
     */
    public function getPluginInputByName($input_name) {
        foreach($this->plugin_config['input'] as $index => $plugin_input){
            if($plugin_input['name'] === $input_name){
                return $plugin_input;
            }
        }
        return null;
    }
}