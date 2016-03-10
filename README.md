## Html5 Promotion

### 依赖

- 无法二维码显示不出来，无法调用图像函数 在php.ini文件中开启一下扩展 extension=php_gd2.dll

### clone 

```shell
$ git clone --recursive git@git.coding.net:zhlhuang/html5-promotion.git
```

### 部署

- 初始化环境
```shell
$  make init-deploy-environment
```

### 更新html5游戏项目

```shell
$ make update-project
```

### 同步到远程

```
$ gulp remote-sync
```
