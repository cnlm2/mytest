<?php
require("../statlog.lib.php");
$this->pageTitle=Yii::app()->name . ' - 绑定YY账号失败';
$this->breadcrumbs=array(
	'绑定YY账号失败',
);
?>
&nbsp;
<h1>绑定YY账号失败</h1>
<br/>
<!--<h3 style="color:red;">恭喜！你已经失败绑定YY账号了游戏，开始你与众不同的大侠之路吧！</h3>-->

<?php if ($model) { ?>
	<?php $form=$this->beginWidget('CActiveForm'); ?>
	<?php echo $form->errorSummary($model); ?>
	<?php $this->endWidget(); ?>
<?php } else{ ?>
	<h3 style="color:red;">绑定YY账号失败。 </h3>
<?php } ?>
<br>

