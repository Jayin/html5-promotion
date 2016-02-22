<?php
namespace Home\Controller;
use Think\Controller;
use Common\Lib\File;

class ProjectController extends Controller{

	/**
	* 显示项目列表
	*/
	public function list(){
		File::mk_dir($dir);
		$dirArray = File::get_dirs(PROJECT_DIR);

		$dirList=$dirArray["dir"];

		$game_list=array();
		foreach ($dirList as $key => $value) {
			$config=File::read_file(PROJECT_DIR."/".$value."/config.json");
			if($config){
				//如果存在config.json 文件则读出
				$game_list[$value]=json_decode($config,1);

			}
		}
		$this->assign('title',"游戏列表");
		$this->assign('project_list',"active"); //菜单样式显示
		$this->assign('game_list',$game_list); //扫描到的游戏列表
		$this->display('list');
	}

	/**
	* 项目编辑
	* @param project_name 项目目录名称
	*/

	public function edit($project_name){
		if(File::read_file(PROJECT_DIR."/".$project_name."/"."config.json")){
			//如果存在源项目，则将源项目复制过去
			if(!File::read_file(PROJECT_DEV_DIR."/".$project_name."/"."config.json"))
				//如果目的项目已经存在编辑，则不覆盖
				File::copy_dir(PROJECT_DIR."/".$project_name,PROJECT_DEV_DIR."/".$project_name);
		}else{
			$this->error("找不到该项目");
		}
		$config=json_decode(File::read_file(PROJECT_DEV_DIR."/".$project_name."/"."config.json"),1); //获取指定配置信息
		$info=json_decode(File::read_file(PROJECT_DEV_DIR."/".$project_name."/"."game_info.json"),1); //获取指定项目信息
		$visit_url="http://".$_SERVER['SERVER_NAME'].__ROOT__."/".PROJECT_DEV_NAME."/".$project_name;

		$this->assign('visit_url',$visit_url);
		$this->assign('project_list',"active"); //菜单样式显示
		$this->assign('config',$config);
		$this->assign('info',$info);
		$this->display("edit");
	}
}