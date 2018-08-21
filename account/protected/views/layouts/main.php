<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>盖世豪侠</title>
    <meta name="description" content="盖世豪侠" />

	<?php
		$cs = Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');
		$cs->registerCoreScript('jquery.ui');
		#$cs->registerCssFile($cs->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
	?>

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/common.css"/>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/common.js"></script>

</head>

<body>


<div id="wrap">
    <div id="main">
        <div id="header">
            <h1>用户中心</h1>
        </div>
		<ul id="nav">
               <li class="nav-1">
			   	<a href="<?php echo $this->createUrl('account/giftcenter')  ?>"><i></i>奖励中心</a>
               </li>
               <li class="nav-2">
			   	<a href="<?php echo $this->createUrl('account/update', array('id'=>Yii::app()->user->id))  ?>"><i></i>账号安全</a>
               </li>
               <li class="nav-3">
			   	<a href="<?php echo $this->createUrl('account/password', array('id'=>Yii::app()->user->id))  ?>"><i></i>修改密码</a>
               </li>
               <li class="nav-4">
			   	<a href="<?php echo $this->createUrl('account/cleartoken')  ?>"><i></i>清除口令</a>
               </li>
               <li class="nav-5">
			   	<a href="<?php echo $this->createUrl('charge/index')  ?>"><i></i>订单列表</a>
               </li>
               <li class="nav-6">
			   	<a href="<?php echo $this->createUrl('charge/create')  ?>"><i></i>账户充值</a>
               </li>
               <li class="nav-7">
			   	<a href="<?php echo $this->createUrl('account/openbbs')  ?>"><i></i>开通论坛</a>
               </li>
			   <?php
					if (Promoter::model()->findByPk(Yii::app()->user->getId())) {
						$url = $this->createUrl('promoter/index');
						echo("<li class='nav-7'>  <a href= $url><i></i>推广查询</a> </li>");
					}
			   ?>
        </ul>
        <div class="main">
			<?php if ( Yii::app()->user->isGuest ) { ?>
			  <a href="<?php echo $this->createUrl('site/fetchpassword') ?>" id="info-more">找回密码</a>
			  <a href="<?php echo $this->createUrl('site/login')?>" id="relog">登 录</a>
			<?php } else { ?>
			  <a href="<?php echo $this->createUrl('account/view', array('id'=>Yii::app()->user->id)) ?>" id="info-more">账号信息</a>
			  <a href="<?php echo $this->createUrl('site/logout') ?>" id="relog">注 销</a>
			<?php } ?>
            
        </div>
        <div id="info"> <?php echo $content; ?></div>
		<!--
        <div id="banner">
            <a href="#" target="_blank">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner.jpg">
            </a>
        </div>
		-->
        <div id="footer">
            <div class="foot">
                <a class="logo"></a>
                <p class="mes">
                    抵制不良游戏，拒绝盗版游戏。注意自我保护，谨慎受骗上当。<br>
                    适度游戏益脑，沉迷游戏伤身。合理安培时间，享受健康生活。
                </p>
                <p class="copyright">
                    深圳莲蓬网络科技有限公司　版权所有 | 0755-26973407<br>
                    粤ICP备13013137 | 粤网文[2013]1010-260号 | ICP证粤B2-20130751号<br>
                    广东省深圳市南山区马家龙大新路金龙工业城63栋东区4楼418
                </p>
            </div>
        </div>
    </div>
</div>
</div>

<div class="mzdialog" id="mzdialog1" style="width: 420px; height: 250px; z-index: 10006; position: absolute; left: 750px; top: 194.5px; display: none;">
	<div class="alertDialog">
		<div class="alertDialogTitle">
		<label class="alertDialogTitleTip">提示</label>
		<a class="alertDialogClose"></a>
	</div>
	<div class="alertDialogMain">
		<div class="alertDialogContent">两次获取验证码的时间差必须大于2分钟</div>
		</div>
		<div class="alertDialogBtnField">
			<a class="fullBtnBlue alertDialogSure">确定</a>
		</div>
	</div>
</div>
<script type="text/javascript">
function resize()
{
	document.getElementById("nav").style.height = document.getElementById("info").offsetHeight + "px";
}
window.setInterval(resize,50);

</script>

</body>
</html>
