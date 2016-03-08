<?php
/**
 * Created by PhpStorm.
 * User: jayin
 * Date: 3/2/16
 * Time: 3:57 PM
 */

namespace Plugin\Plugins;


use Common\Lib\File;

abstract class Plugin {
    /**
     * @var 插件的配置
     */
    protected $plugin_config;
    /**
     * @var 插件名
     */
    private $plugin_name;
    /**
     * @var 该插件所属的项目名
     */
    private $project_name;

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
     * @return 该插件所属的项目名
     */
    public function getProjectName() {
        return $this->project_name;
    }

    /**
     * @param 该插件所属的项目名 $project_name
     */
    public function setProjectName($project_name) {
        $this->project_name = $project_name;
    }

    /**
     * @return 插件名
     */
    public function getPluginName() {
        return $this->plugin_name;
    }

    /**
     * @param 插件名 $plugin_name
     */
    public function setPluginName($plugin_name) {
        $this->plugin_name = $plugin_name;
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

    /**
     * 保存数据到 project_dev/__resource/{plugin_name}/data.json
     * @param $data
     * @return bool
     */
    public function saveProjectDataJSON($data){
        $plugin_dir = C('PROJECT_DEV_DIR').'/'.$this->getProjectName().'/__resource/'.$this->getPluginName();
        File::mk_dir($plugin_dir);
        $data_file = $plugin_dir.'/data.json';
        return File::write_file($data_file, json_encode($data));
    }

    /**
     * 复制资源目录
     */
    public function copyResource(){
        $resource_dir = APP_ROOT_PATH. '/Application/Plugin/Plugins/'. $this->getPluginName() . '/__resource';
        $target_resource_dir = C('PROJECT_DEV_DIR').'/'.$this->getProjectName(). '/__resource';

        File::copy_dir($resource_dir, $target_resource_dir);
    }
}