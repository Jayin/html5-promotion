# Wxuserinfo

获取微信授权用户基础信息

微信网页授权认证
- 注入app id + secret
- 用户信息注入在全局变量`window.__html5userinfo` 正确时返回的JSON数据包如下：

```
{
    "openid":" OPENID",
    " nickname": NICKNAME,
    "sex":"1",
    "province":"PROVINCE"
    "city":"CITY",
    "country":"COUNTRY",
    "headimgurl": "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46", 
    "privilege":[
        "PRIVILEGE1"
        "PRIVILEGE2"
    ],
    "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
}

```

### 使用

NOTE: 只能应用于php文件

- 添加配置

```
{
    "plugins": [
        ........
        "Wxuserinfo"
    ],
    "config": {
      
      "Wxuserinfo": {
        "description": "获取授权的微信用户的信息",
        "regex": "<!-- WX_USER_INFO -->",
        "files": [
          "index.php" //只能用于php
        ],
        "input": [
          {
            "name": "enable",
            "description": "是否开启获取授权的微信用户信息",
            "type": "radio"
          },
          {
            "name": "appid",
            "description": "AppID(应用ID)",
            "type": "text"
          },{
            "name": "appsecret",
            "description": "AppSecret(应用密钥)",
            "type": "text"
          }
        ]
      }
    }
}
```

- 2.添加到需要授权的网页中

注意：必须要放到`<html>`标签内

```
<head>
    <title>你能精准地按出一秒吗？</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <!-- WX_USER_INFO -->
```


拓展：
- 分析微信用户信息？

## 截图

![图片1](https://dn-coding-net-production-pp.qbox.me/c9ac7ba0-bdec-4cf3-a98f-4cb9449d1a83.png) 
![图片2](https://dn-coding-net-production-pp.qbox.me/264657f7-33aa-4444-a982-e46024ca4f44.png) 