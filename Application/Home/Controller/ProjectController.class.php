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

}