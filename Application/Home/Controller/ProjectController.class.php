<?php
namespace Home\Controller;
use Think\Controller;
use Common\Lib\File;

class ProjectController extends Controller{

	/**
	* 显示项目列表
	*/
	public function listProject(){
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


	/**
	* 更新项目中的图片
	*/

	public function upload_img(){
		$project_name=I("project_name");
		$img_path=I("img_path");
		$img_name=I("img_name");
		$img_ext=I("img_ext");
		$upload = new \Think\Upload();// 实例化上传类
		$upload->exts      =   array($img_ext);// 设置附件上传类型
		$upload->rootPath=PROJECT_DEV_DIR; //上传的根目录
		$upload->savePath  = '/'.$project_name.'/'.$img_path; // 相对于根目录，设置附件上传目录
		$upload->saveName = $img_name; //设置文件上传名称
		$upload->autoSub=false; //没有上传子目录结构
		$upload->replace=true;//允许替换文件

		$info=$upload->uploadOne($_FILES['new_img']);
		if(!$info) {// 上传错误提示错误信息
			$this->error($upload->getError());
		}else{// 上传成功 获取上传文件信息
			// echo $info['savepath'].$info['savename'];
			$this->redirect('edit',array("project_name"=>$project_name));
		}
	}
}
