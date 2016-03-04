<?php


$start_year = '__start_year__';
$start_month = '__start_month__';
$start_day = '__start_day__';
$start_hour = '__start_hour__';
$start_minute = '__start_minute__';
$start_second = '__start_second__';

$end_year = '__end_year__';
$end_month = '__end_month__';
$end_day = '__end_day__';
$end_hour = '__end_hour__';
$end_minute = '__end_minute__';
$end_second = '__end_second__';

$now_date = new \DateTime();
$now_date->setTimezone(new \DateTimeZone('Asia/Shanghai'));

$start_date = new \DateTime();
$start_date->setTimezone(new \DateTimeZone('Asia/Shanghai'));
$start_date->setDate($start_year, $start_month, $start_day);
$start_date->setTime($start_hour, $start_minute, $start_second);


$end_date = new \DateTime();
$end_date->setTimezone(new \DateTimeZone('Asia/Shanghai'));
$end_date->setDate($end_year, $end_month, $end_day);
$end_date->setTime($end_hour, $end_minute, $end_second);


if ($now_date->getTimestamp() >= $start_date->getTimestamp() && $now_date->getTimestamp() <= $end_date->getTimestamp()) {
    //可以正常访问
} else {
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

    redirect('__redirect__');
}

?>