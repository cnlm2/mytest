<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
&nbsp;
<!--
<h1>欢迎来到<b>拍拍富</b>用户中心，您可以：</h1>
-->
<h1> </h1>
&nbsp;
<!--
<div class="portlet-content">
-->

<?php
	$menu = array();

	if (Yii::app()->user->name !== 'Guest') {
		array_push($menu, array('label'=>'注册查询', 'url'=>array('promoter/reg')));
		array_push($menu, array('label'=>'充值查询', 'url'=>array('promoter/charge')));
		array_push($menu, array('label'=>'玩家查询', 'url'=>array('promoter/player')));
	}
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>'推广查询',
	));
	$this->widget('zii.widgets.CMenu', array(
		'items'=> $menu,
		'htmlOptions'=>array('class'=>'operations'),
	));
	$this->endWidget();
?>

</div>

