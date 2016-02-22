<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {
	public function index() {
		$this->assign('homePage', "active"); //菜单选择样式
		$this->assign('title', "主页"); //标题显示
		$this->display("index");
	}
}