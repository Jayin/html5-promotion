<?php
namespace Home\Controller;

use Think\Controller;
use Common\Lib\File;
use Home\Service\ProjectService;

class ProjectController extends Controller {

    /**
     * 显示项目列表页
     */
    public function listProject() {
        $dirArray = File::get_dirs(C('PROJECT_DIR'));

        $dirList = $dirArray["dir"];

        $game_list = array();
        foreach ($dirList as $key => $value) {
            if ($value === '.' || $value === '..') {
                continue;
            }
            $config = File::read_file(C('PROJECT_DIR') . "/" . $value . '/' . C('PROJECT_CONFIG_FILE'));
            if ($config) {
                //如果存在config.json 文件则读出
                $game_list[$value] = json_decode($config, 1);

            }
        }
        $this->assign('title', "游戏列表");
        $this->assign('project_list', "active"); //菜单样式显示
        $this->assign('game_list', $game_list); //扫描到的游戏列表
        $this->display('listproject');
    }

    /**
     * 列出打包项目
     */
    public function listPackPackage() {
        $dirArray = File::get_dirs(C('PROJECT_PACKAGE_DIR'));

        $dirList = $dirArray["dir"];

        $game_list = array();
        foreach ($dirList as $key => $value) {
            $config = File::read_file(C('PROJECT_PACKAGE_DIR') . "/" . $value . '/' . C('PROJECT_CONFIG_FILE'));
            if ($config) {
                //如果存在config.json 文件则读出
                $game_list[$value] = json_decode($config, 1);
                $game_list[$value]['pack_project_name'] = $value; //打包后的文件名
            }
        }
        $this->assign('game_list', $game_list); //扫描到的游戏列表
        $this->assign('package_list', "active"); //菜单样式显示
        $this->display('listpackpackage');
    }

    /**
     * 项目编辑页
     * @param 项目目录名称 $project_name
     * @param string $edit_page
     * @internal param 项目目录名称 $project_name
     */
    public function edit($project_name, $edit_page = '') {
        if (ProjectService::projectExist($project_name)) {
            //如果存在源项目，则将源项目复制过去
            if (!ProjectService::projectDevtExist($project_name)) {
                //如果目的项目已经存在编辑，则不覆盖
                ProjectService::projectCopyToDev($project_name);
            }
        } else {
            $this->error("找不到该项目");
        }
        $config = ProjectService::readProjectDevConfig($project_name);//获取指定配置信息
        $info = ProjectService::readProjectDevInfoConfig($project_name); //获取指定项目信息
        $plugin_config = ProjectService::readProjectDevPluginConfig($project_name);

        if (!$edit_page) {
            $edit_page = $config['edit_page'][0]['id'];
        }
        $pageInfo = $this->getPageInfoById($config['edit_page'], $edit_page);
        //预览url
        $preview_url = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . __ROOT__ . "/" . PROJECT_DEV_NAME . "/" . $project_name . '/' . $pageInfo['page'];
        //预览根目录
        $preview_base = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . __ROOT__ . "/" . PROJECT_DEV_NAME . "/" . $project_name;

        $this->assign('edit_page', $edit_page);
        $this->assign('preview_url', $preview_url);
        $this->assign('preview_base', $preview_base);
        $this->assign('project_list', "active"); //菜单样式显示
        $this->assign('config', $config);
        $this->assign('info', $info[$edit_page]);
        $this->assign('plugin_config', $plugin_config);
        $this->display("edit");
    }

    /**
     * 删除打包项目
     */
    public function deletePackProject() {
        $pack_project_name = I('pack_project_name');
        ProjectService::deletePackProject($pack_project_name);
        $this->success('删除成功');
    }

    //获取根据page.id 获取该edit_page信息
    private function getPageInfoById($pages, $page_id) {
        foreach ($pages as $page) {
            if ($page['id'] === $page_id) {
                return $page;
            }
        }
        return null;
    }

    //项目编辑重置
    public function reset($project_name) {
        //del_dir
        File::del_dir(PROJECT_DEV_DIR . "/" . $project_name);
        $this->redirect('edit', array("project_name" => $project_name));
    }

    /**
     * 打包到package/打包成一个压缩包
     * @param $project_name
     */
    public function package($project_name) {
        ProjectService::package($project_name);
        $this->success("打包完成!");
    }

    /**
     * 更换文字内容
     */
    public function updateText() {
        $project_name = I('post.project_name');
        $regex = I('post.regex', '', '');
        $text = I('post.text', '', '');
        $edit_page = I('post.edit_page');
        $type = 'texts';
        $files = I('post.files', array());

        foreach ($files as $index => $file) {
            ProjectService::updateText($project_name, $file, $regex, $text);
            ProjectService::updateProjectInfoRegex($project_name, $edit_page, $type, $regex, $text);

        }

        $this->redirect('edit', array('project_name' => $project_name, 'edit_page' => $edit_page));
    }

    /**
     * 更新项目中的图片
     */
    public function upload_img() {
        $project_name = I("project_name");
        $img_path = I("img_path");
        $img_name = I("img_name");
        $img_ext = I("img_ext");
        $upload = new \Think\Upload();// 实例化上传类
        $upload->exts = array($img_ext);// 设置附件上传类型
        $upload->rootPath = PROJECT_DEV_DIR; //上传的根目录
        $upload->savePath = '/' . $project_name . '/' . $img_path; // 相对于根目录，设置附件上传目录
        $upload->saveName = 'time'; //设置文件上传名称
        $upload->autoSub = false; //没有上传子目录结构
        $upload->replace = true;//允许替换文件

        $info = $upload->uploadOne($_FILES['new_img']);
        $srcFile = $upload->rootPath . $upload->savePath . $info['savename'];
        $destFile = $upload->rootPath . $upload->savePath . $img_name . '.' . $img_ext;

        copy($srcFile, $destFile);
        File::del_file($srcFile);
        if (!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        } else {// 上传成功 获取上传文件信息
            // echo $info['savepath'].$info['savename'];
            $this->redirect('edit', array("project_name" => $project_name));
        }
    }
}
