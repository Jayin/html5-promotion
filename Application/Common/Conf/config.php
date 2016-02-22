<?php
return array(
	//'配置项'=>'配置值'
	'URL_MODEL' => 2, //URL模式 REWRITE模式
	'LOG_RECORD' => true, // 开启日志记录 (开发模式启动)
	'LOG_TYPE' => 'File', // 日志记录类型 默认为文件方式
	'TMPL_TEMPLATE_SUFFIX' => '.html',
	'URL_HTML_SUFFIX' => 'html|phtml', // 伪静态后缀名设置
	'LOAD_EXT_FILE' => 'functions',
	'URL_CASE_INSENSITIVE' => true, //不区分URL大小写
	'MULTI_MODULE' => false,
	'DEFAULT_MODULE' => 'Home', //设置该项目是单模块
	//数据库
	'db_type' => 'mysql', // 数据库类型
	'db_host' => '127.0.0.1', //不能用域名，解析会浪费时间
	'db_port' => '3306',
	'db_name' => 'html5', // 数据库名称
	'db_user' => 'html5', // 主机名
	'db_pwd' => 'html5', // 密码

	'PROJECT_DIR' => APP_ROOT_PATH . "/Project", //项目模板存放路径
	'PROJECT_NAME' => "Project", //项目目录名称
	'PROJECT_DEV_DIR' => APP_ROOT_PATH . "/Project_dev", //编辑项目存放路径
	'PROJECT_DEV_NAME' => "/Project_dev", //编辑项目目录名称

);