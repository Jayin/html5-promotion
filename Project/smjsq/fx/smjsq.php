<?php
	date_default_timezone_set("PRC");
	$do = $_POST['do'];
	$time = $_POST['time'];
	if($do == "view"){
		$year = substr($time, 0,4);
		$month = substr($time, 4,2);
		$day = substr($time, 6,2);
		$both_data = mktime(0,0,0,$month,$day,$year);
		$now = time();
		$a = $now - $both_data;
		$sui = $a/365/24/60/60;  //最上边的那个数
		$nian = floor($sui);	//年
		$yue = floor($a/60/60/24/365*12);	//月
		$zhou = floor($a/60/60/24/7);	//日
		$tian = floor($a/60/60/24);		//天
		$shi = floor($a/60/60);		//小时
		$fen = floor($a/60);		//分钟
		$miao = floor($a);			//秒
		$data['txt'] = $sui;
		$data['li'] = '<li class="list_first">
	         <h6 class="text-muted">你已经存在了</h6>
	         </li>
	         <li> <strong>'.$nian.'</strong> 年 </li>
	         <li> <strong>'.$yue.'</strong> 月 </li>
	         <li> <strong>'.$zhou.'</strong> 周 </li>
	         <li> <strong>'.$tian.'</strong> 天</li>
	         <li> <strong>'.$shi.'</strong> 小时 </li>
	         <li> <strong>'.$fen.'</strong> 分钟 </li>
	         <li> <strong>'.$miao.'</strong> 秒 </li>';
	    $data['day'] = $tian;
	    
		header('Content-Type: application/json');
		echo json_encode($data);
	}elseif ($do == 'future') {
		$day = $_POST['day'];
		$total_day = 100 * 365 + 25;
		$day = $total_day - $day;		//天数
		$meal = $day * 3;			// 吃饭
		$xizao = floor($day / 2);	//洗澡
		$bing = floor($day / 365);	//生病
		$zhoumo = floor($day/7);	// 周末
		$pi = ($day * 5);		// 放屁
		$meng = floor($day - 1); 	// 做梦
		$chao = floor($day / 60);	// 吵架
		$zhayan = $day * 100;		//眨眼
		$liu	= floor($day / 30); //流泪
		$huang	= floor($day / 15); //说谎
		$zhijia = floor($day / 30); //剪指甲
		$shui 	= floor($day * 4); //喝水
		$data['txt'] = $day;
		$data['li'] = '<li class="list_first">
          <h6 class="text-muted">剩下的日子里，你大约可以</h6> 
          </li>
          <li> 睡 <strong>'.$day.'</strong> 次觉 </li>
          <li> 吃 <strong>'.$meal.'</strong> 顿饭 </li>
          <li> 洗 <strong>'.$xizao.'</strong> 次澡 </li>
          <li> 生 <strong>'.$bing.'</strong> 次病 </li>
          <li> 过 <strong>'.$zhoumo.'</strong> 个周末 </li>
          <li> 放 <strong>'.$pi.'</strong> 个屁 </li>
          <li> 做 <strong>'.$meng.'</strong> 个梦 </li>
          <li> 吵 <strong>'.$chao.'</strong> 次架 </li>
          <li> 眨 <strong>'.$zhayan.'</strong> 次眼 </li>
          <li> 流 <strong>'.$liu.'</strong> 次泪 </li>
          <li> 说 <strong>'.$huang.'</strong> 次谎 </li>
          <li> 剪 <strong>'.$zhijia.'</strong> 次指甲 </li>
          <li> 喝 <strong>'.$shui.'</strong> 杯水 </li>';
        header('Content-Type: application/json');
        echo json_encode($data); 
	}
	
?>