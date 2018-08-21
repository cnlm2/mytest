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
<h3><strong class="title-4">帐号安全</strong></h3>

&nbsp;
<!--
<div class="ss-tile">清除口令</div>
-->
<?php
	$menu = array();

	if (Yii::app()->user->name !== 'Guest') {

		array_push($menu, array('label'=>'通过手机清除', 'url'=>array('account/cleartokenmobile')));
		//array_push($menu, array('label'=>'通过邮箱清除', 'url'=>array('account/sendcleartokenmail')));
	}
	$this->beginWidget('zii.widgets.CPortlet', array(
	));
	$this->widget('zii.widgets.CMenu', array(
		'items'=> $menu,
		'htmlOptions'=>array('class'=>'update'),
	));
	$this->endWidget();
?>

