<?php
/* @var $this AccountController */
/* @var $model Account */

$this->breadcrumbs=array(
	'密码找回',
);

$this->initMenu();
?>
<h3><strong class="title-9">密码找回</strong></h3>

&nbsp;
<!--
<div class="ss-tile">修改密码</div>
-->
<?php
	$menu = array();
	array_push($menu, array('label'=>'通过手机找回', 'url'=>array('site/fetchpasswordmobile')));
	array_push($menu, array('label'=>'通过邮箱找回', 'url'=>array('site/fetchpasswordmail')));

	$this->beginWidget('zii.widgets.CPortlet', array(
	));
	$this->widget('zii.widgets.CMenu', array(
		'items'=> $menu,
		'htmlOptions'=>array('class'=>'update'),
	));
	$this->endWidget();
?>

