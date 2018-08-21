<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link href="/css/chunjie.css" rel="stylesheet" type="text/css">
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/zt131025.css" />
	<link rel="stylesheet" type="text/css" href="/css/ztcontent.css" />
	<?php
		$cs = Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');
		$cs->registerCoreScript('jquery.ui');
	?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">
	<div class = "linkcj" style="left:627px; top:161px;"><a href="/account/index.php/account/drawrewardroll?v=123" target="_blank" title="我要抽奖"></a></div>
	<div class = "linkhome" style="left:627px; top:205px;"><a href="/chunjie/zhuanti3.php" target="_blank" title="返回专题"></a></div>
	<div class = "linktxt" style="left:20px; top:310px;"><a href="/chunjie/cjqd.php" target="_blank" title="春节签到"></a></div>

	<div class = "linktxt1" style="left:210px; top:310px;"><a href="/chunjie/czfl.php" title="充值返利"></a></div>
		<div class = "linktxt2" style="left:400px; top:310px;"><a href="/chunjie/bnlhb.php" title="拜年领红包"></a></div>
			
			<div class = "linktxt3" style="left:590px; top:310px;"><a href="/chunjie/rclj.php" title="任务连击"></a></div>
			<div class = "linktxt3" style="left:20px; top:380px;"><a href="/chunjie/xsns.php" title="战夕兽年兽"></a></div>
			<div class = "linktxt3" style="left:210px; top:380px;"><a href="/chunjie/tjxr.php" title="天降祥瑞"></a></div>
			<div class = "linktxt3" style="left:400px; top:380px;"><a href="/chunjie/yhwh.php" title="烟火舞会"></a></div>
			<div class = "linktxt3" style="left:590px; top:380px;"><a href="/chunjie/jfdh.php" title="积分兑换"></a></div>
	
	<div class = "linktxt4" style="left:873px; top:494px;"><a href="/zhuanti1.html" title="返回专题"></a></div>

	<div class = "linkrighttop" style="left:799px; top:5px; color:#a3cbd7;" >
		<a style="font-size:12px; bold;color: #ffe823;" href="/index2_new.html" title="进入官网"  target="_blank">进入官网</a> |
		<a style="font-size:12px; bold;color: #ffe823;" href="/account/index.php/charge/create" title="充值中心"  target="_blank" >充值中心</a> |
		<a style="font-size:12px; bold;color: #ffe823;" href="/content.php?t1=3&t2=downloadgame" title="游戏下载"  target="_blank">游戏下载</a>
	</div>

	<div id="header"> </div><!-- header -->

	<div id="maincontent" class="span-23"><?php echo $content; ?> </div>

	<div class="clear"></div>


</div><!-- page -->

	<div class="footer" style="background-color:rgb(248,253,253);">
		<div class="footerdl" style="background-color:rgb(248,253,253);margin:auto;width:700px;">
			<div class="footer_icon" style="padding:25px 10px 0px 110px;float:left;">
				<a href="/" target="_blank" hidefocus="true"><img src="/images/media/lianpeng3.png" border="0"></a>
            </div>
			<div class="footer_text" style="float:left;font-size:9pt;">
				<p style="padding:10px 10px 4px 0px;margin:0px;">深圳莲蓬网络科技有限公司 版权所有 | 0755-26973407</p>
			    <p style="padding:0px 10px 4px 0px;margin:0px;">粤ICP备13013137号 | 粤网文[2013]1010-260号 | ICP证粤B2-20130751号 </p>
			    <p style="padding:0px 10px 10px 0px;margin:0px;">广东省深圳市南山区马家龙大新路金龙工业城63栋东区4楼418</p>
			</div>
			<div class="clear"></div>
		</div>
	</div><!-- end .footer -->

<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F67e4b81962616784cf0b52ca08395c8e' type='text/javascript'%3E%3C/script%3E"));
</script>

</body>
	<script>
		function winconfirm(){
			question = confirm("暂未开放，尽请期待!")
			if (question != "0"){
			}
		}
	</script>
</html>
