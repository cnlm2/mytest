<?php
/* @var $this AccountController */
/* @var $model Account */

$this->breadcrumbs=array(
	'用户'=>array('index'),
	$model->name,
);

$this->initMenu();
?>
<!--
&nbsp;
<h1>用户基本信息</h1>
&nbsp;
-->
<h3><strong class="title-info">帐户信息</strong></h3>
&nbsp;
&nbsp;
<?php if (Yii::app()->user->getState('info')) { ?>
<p style="color:red"><?php echo Yii::app()->user->getState('info'); ?>
<?php	if (strpos(Yii::app()->user->getState('info'), "邮") != false) { ?>
<br/>近期QQ邮箱接收验证邮件不稳定，请参考<a href="/bbs/forum.php?mod=viewthread&tid=1082&extra=page%3D1">此文</a>解决
<?php	} ?>
</p>
<?php Yii::app()->user->setState('info', Null); } ?>
<?php
$formater = new ShadowFormatter();
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'formatter'=>$formater,
	'attributes'=>array(
		//'id',
		'account',
		//'password',
		'email',
		'balance',
		'time',
	),
));

//if ($model->verified == 0) {
//	echo "<p style=\"padding-top:20px\">您的邮箱尚未验证，手动".CHtml::link("发送验证邮件", array("sendverify"))."</p>";
//}

?>
