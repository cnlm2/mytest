
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/zhp.css" />
<div class="disk">
<style type="text/css">
.start{width:164px; height:320px; position:absolute; top:92px; left:163px;}
</style>
<div id="start" class="start"><img src="/images/huodong/gqreward/start.png" id="startbtn"></div>
<script type="text/javascript" src="/js/zhp/jQueryRotate.2.2.js"></script>
<script type="text/javascript" src="/js/zhp/jquery.easing.min.js"></script>
<script type="text/javascript">
$(function () {
    $("#startbtn").click(function () {
		lottery();
	});
});
	
function lottery() {
	$.ajax({
		type: 'POST',
		url: '/account/index.php/account/drawrewardroll',
		data: "v=<?php echo $key ?>",
		dataType: 'json',
		cache: false,
		error:function(){
			alert("转盘无法转动！");
		},
		success: function (json) {
			var a = json.angle;
			var p = json.prize;
			if (a == -1799) {
				alert(p);
				return;
			}
			$("#startbtn").unbind('click').css("cursor", "default");
			$("#startbtn").rotate({
				duration: 3000, //转动时间 
				angle: 0, //默认角度
				animateTo: 1800 + a, //转动角度 
				easing: $.easing.easeOutSine,
				callback: function () {
					alert( p );
					$("#startbtn").rotate({ angle: a });
					$("#startbtn").click(function () { lottery(); }).css("cursor", "pointer");
					parent.location.reload();
				}
			});
		}
	
	});
}
</script>

</div>

<div id="text" class="content">
<h3>活动对象：</h3>
    <p>所有服务器的玩家 </p>
<h3>抽奖时间：</h3>
    <p>2014年8月12日12:00 至 2014年8月26日 23:59</p>
<h3>实物奖名单公布日期：</h3>
    <p>2014年8月27日 至 2014年8月29日</p>
<h3>活动内容:</h3>
	<p>登录游戏后，点击游戏左上角的活动按钮弹出开服活动界面，点击下载客户端抽奖按钮进入抽奖页面进行抽奖。 </p>
<h3>领奖方法:</h3>
<p>1.抽奖成功后若获得虚拟道具奖，则会获得对应奖励的CDKey，登录游戏后点击左上角礼包按钮进入礼包页面，在媒体礼包页面输入CDKey后即可获得相应奖励。</p>
<p>2.抽奖内容若为实物道具奖励，请于2014年9月15日之前使用获奖账号的验证邮箱将电话、联系地址【QB奖励则需告知需充值的QQ号】发给官方人员，官方人员会在若干工作日内将奖励通过邮递等形式发放给玩家。</p>
<p>3.逾期尚未联系官方人员的玩家则视为放弃奖励。 </p>
<p><strong>官方人员邮箱：</strong>kechun@tlqxol.com</p>
<p><strong>客服QQ：</strong>1502914012 </p>
	</p>
</div>

