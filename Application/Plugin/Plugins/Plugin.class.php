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




    abstract function getContent();
}