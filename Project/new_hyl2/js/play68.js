function play68_init() {
	updateShare(0);
}


function play68_submitScore(score) {
	updateShareScore(score);
	Play68.shareFriend();
	 // setTimeout( function() { Play68.shareFriend(); }, 1000 )
}

function updateShare(perfection) {
	var descContent = "以真诚为半径，用尊重为圆心，画一个圆圆的月亮送亲人！";
    var score = (perfection * 100).toFixed(2);
	if (perfection == 0) {
		shareTitle = '中秋画月亮，送祝福！月圆，人更圆！就看你画得圆不圆。';
	}else if (perfection < 0.1) {
        shareTitle = '我画了个'+score+'分的月亮，我的世界基本已经告别月亮了。';
    } else if (perfection < 0.5) {
        shareTitle = '我画了个'+score+'分的月亮，你看得见吗？';
    } else if (perfection < 0.7) {
        shareTitle = '我画了个'+score+'分的月亮，嫦娥已经被我的月亮丑哭了！';
    } else if (perfection < 0.8) {
        shareTitle = '我画了个'+score+'分的月亮，我这是苗条的月亮！';
    } else if (perfection < 0.9) {
        shareTitle = '我画了个'+score+'分的月亮，我的月亮有种自然美。';
    } else if (perfection < 0.93) {
        shareTitle = '我画了个'+score+'分的月亮，比达芬奇的鸡蛋要圆多了！';
    } else if (perfection < 0.94) {
        shareTitle = '我画了个'+score+'分的月亮，中秋看我画的月亮就够了！';
    } else if (perfection < 0.95) {
        shareTitle = '我画了个'+score +'分的月亮，人月两团圆，千里共婵娟';
    } else if (perfection < 0.96) {
        shareTitle = '我画了个'+score+'分的月亮，我画得月亮圆又圆，一生有福“缘”';
    } else if (perfection < 0.97) {
        shareTitle = '我画了个'+score+'分的月亮，一送月圆不花钱，二送人圆无时限';
    } else if (perfection < 0.98) {
        shareTitle = '我画了个'+score+'分的月亮，祝你梦圆，情圆，人更圆！';
    } else if (perfection < 0.99) {
        shareTitle = '我画了个'+score+'分的月亮，我就是那十五的月亮，月圆人更圆！';
    } else {
        shareTitle = '我画了个'+score+'分的月亮，我就是十六的月亮，月圆人更圆！';
    }
	//appid = '';
	//Play68.setShareInfo(shareTitle,descContent);
    document.title = shareTitle;
    window.shareData.desc = shareTitle;
}

function updateShareScore(bestScore) {
  updateShare(bestScore); 
}