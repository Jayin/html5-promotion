<?php

function http_req($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);
    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
}

/**
 * URL重定向
 *
 * @param string  $url  重定向的URL地址
 * @param integer $time 重定向的等待时间（秒）
 * @param string  $msg  重定向前的提示信息
 * @return void
 */
function redirect($url, $time = 0, $msg = '') {
    //多行URL地址支持
    $url = str_replace(array("\n", "\r"), '', $url);
    if (empty($msg)) {
        $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
    }
    if (!headers_sent()) {
        // redirect
        if (0 === $time) {
            header('Location: ' . $url);
        } else {
            header("refresh:{$time};url={$url}");
            echo($msg);
        }
        exit();
    } else {
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if ($time != 0) {
            $str .= $msg;
        }
        exit($str);
    }
}

function getUserInfo($appid, $appsecret) {
    $redirect_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $weixin_auth = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $appid . '&redirect_uri=' . urlencode($redirect_url) . '&response_type=code&scope=snsapi_userinfo&state=ZHUTIBANG#wechat_redirect';

    $code = $_GET['code'] ? $_GET['code'] : '';
    if ($code) {
        $at_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $appsecret . '&code=' . $code . '&grant_type=authorization_code';
        $res = http_req($at_url);
        $res = json_decode($res, true);
        //code 只能使用一次,第二次访问应该重新授权
        if ($res['errcode']) {
            redirect($weixin_auth);

            return;
        }
        $info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $res['access_token'] . '&openid=' . $res['openid'] . '&lang=zh_CN';
        $user_info = http_req($info_url);
        $user_info = json_decode($user_info, true);

        $tpl_content = file_get_contents(__DIR__ . '/inject-userinfo.html');
        $tpl_content = str_replace('__openid__', $user_info['openid'], $tpl_content);
        $tpl_content = str_replace('__nickname__', $user_info['nickname'], $tpl_content);
        $tpl_content = str_replace('__sex__', $user_info['sex'], $tpl_content);
        $tpl_content = str_replace('__language__', $user_info['language'], $tpl_content);
        $tpl_content = str_replace('__city__', $user_info['city'], $tpl_content);
        $tpl_content = str_replace('__province__', $user_info['province'], $tpl_content);
        $tpl_content = str_replace('__country__', $user_info['country'], $tpl_content);
        $tpl_content = str_replace('__headimgurl__', $user_info['headimgurl'], $tpl_content);
        $tpl_content = str_replace('__privilege__', $user_info['privilege'], $tpl_content);

        echo $tpl_content;
    } else {
        redirect($weixin_auth);
    }
}

function main() {
    $data_json = file_get_contents(__DIR__ . '/data.json');
    $data = json_decode($data_json, true);
    if (!$data || !$data['appid'] || !$data['appsecret']) {
        echo "需要: appid、appsecret";
        exit();
    }
    getUserInfo($data['appid'], $data['appsecret']);
}

main();

?>


