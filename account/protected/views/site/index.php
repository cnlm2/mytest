<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
&nbsp;
<h1>欢迎来到<b>盖世豪侠</b>用户中心，您可以：</h1>
&nbsp;

<div class="portlet-content">

<?php
	$menu = array();

	if (Yii::app()->user->name === 'Guest') {
		//array_push($menu, array('label'=>'注册用户', 'url'=>array('account/create')));
		array_push($menu, array('label'=>'找回密码', 'url'=>array('site/fetchpassword')));
	}
	if (Yii::app()->user->name !== 'Guest') {
		if (!Activation::isActivated(Yii::app()->user->id)) {
		//array_push($menu, array('label'=>'激活游戏', 'url'=>array('account/activationkey')));
			//array_push($menu, array('label'=>'激活游戏', 'url'=>array('site/activate')));
			//array_push($menu, array('label'=>'限量抽码', 'url'=>array('account/activationkey')));
		}

		array_push($menu, array('label'=>'奖励中心', 'url'=>array('account/giftcenter')));
		array_push($menu, array('label'=>'账号安全', 'url'=>array('account/update','id'=>Yii::app()->user->id)));
		array_push($menu, array('label'=>'修改密码', 'url'=>array('account/password','id'=>Yii::app()->user->id)));
		array_push($menu, array('label'=>'清除口令', 'url'=>array('account/sendcleartoken')));
		array_push($menu, array('label'=>'订单列表', 'url'=>array('charge/index')));
		array_push($menu, array('label'=>'账户充值', 'url'=>array('charge/create')));
		array_push($menu, array('label'=>'开通论坛', 'url'=>array('account/openbbs')));

		if (!Account::isAntiaddiction(Yii::app()->user->id)) {
			array_push($menu, array('label'=>'防沉迷验证', 'url'=>array('account/antiaddiction')));
		}
		//if (!Account::isBindYY(Yii::app()->user->id)) {
		//	array_push($menu, array('label'=>'绑定YY账号', 'url'=>array('account/bindyy')));
		//} else {
		//	array_push($menu, array('label'=>'解绑YY账号', 'url'=>array('account/sendclearyy')));
		//}
		//array_push($menu, array('label'=>'春节抽奖', 'url'=>array('account/drawrewardroll')));
	}
	if (Yii::app()->user->name === 'admin') {
		array_push($menu, array('label'=>'管理产品', 'url'=>array('product/admin')));
		//array_push($menu, array('label'=>'生成激活码', 'url'=>array('site/keygen')));
		//array_push($menu, array('label'=>'生成卡号', 'url'=>array('site/cardgen')));
		//array_push($menu, array('label'=>'双生成卡激活码(一码两用)', 'url'=>array('site/doublegen')));
	};

	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>'操作列表',
	));
	$this->widget('zii.widgets.CMenu', array(
		'items'=> $menu,
		'htmlOptions'=>array('class'=>'operations'),
	));
	$this->endWidget();
?>

</div>

