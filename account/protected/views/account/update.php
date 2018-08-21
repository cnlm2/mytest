<?php
/* @var $this AccountController */
/* @var $model Account */

$this->breadcrumbs=array(
	'用户'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'修改',
);

$this->initMenu();
?>
<h3><strong class="title-2">帐号安全</strong></h3>

&nbsp;
<!--
<div class="ss-tile">账号安全</div>
-->
<?php
	$menu = array();

	if (Yii::app()->user->name !== 'Guest') {
		array_push($menu, array('label'=>'绑定手机', 'url'=>array('account/bindmobile')));
		//array_push($menu, array('label'=>'绑定邮箱', 'url'=>array('account/bindmail')));
		array_push($menu, array('label'=>'防沉迷验证', 'url'=>array('account/antiaddiction')));
	}
	$this->beginWidget('zii.widgets.CPortlet', array(
	));
	$this->widget('zii.widgets.CMenu', array(
		'items'=> $menu,
		'htmlOptions'=>array('class'=>'update'),
	));
	$this->endWidget();
?>

