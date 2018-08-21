<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<?php
		$cs = Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');
		$cs->registerCoreScript('jquery.ui');
		#$cs->registerCssFile($cs->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
	?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script>
		var _hmt = _hmt || [];
		_hmt.push(['_setAccount','67e4b81962616784cf0b52ca08395c8e']);
	</script>
	<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan style='display:none;' id='cnzz_stat_icon_1254679751'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/z_stat.php%3Fid%3D1254679751' type='text/javascript'%3E%3C/script%3E"));</script>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><!--span><?php #echo CHtml::encode(Yii::app()->name); ?></span--></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'账号管理', 'url'=>array('/site/index')),
				//array('label'=>'充值中心', 'url'=>array('/charge/create')),
				array('label'=>'奖励中心', 'url'=>array('/account/giftcenter')),
				//array('label'=>'关于', 'url'=>array('/site/page', 'view'=>'about')),
				//array('label'=>'联系我们', 'url'=>array('/site/contact')),
				array('label'=>'登录', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'注销 ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<div id="bread">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	</div>
	
	<div id="maincontent" class="span-23"><?php echo $content; ?> </div>

	<div class="clear"></div>

	<div class="footer" style="background-color:rgb(248,253,253);">
		<div class="footerdl" style="background-color:rgb(248,253,253);margin:0px 100px 0px 100px;border-top:1px solid rgb(81,160,149);">
			<div class="footer_icon" style="padding:17px 10px 0px 110px;float:left;">
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
</div><!-- page -->

<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F67e4b81962616784cf0b52ca08395c8e' type='text/javascript'%3E%3C/script%3E"));
</script>

</body>
</html>
