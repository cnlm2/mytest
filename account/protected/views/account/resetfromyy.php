<?php
$this->pageTitle=Yii::app()->name . ' - 成功绑定莲蓬账号';
$this->breadcrumbs=array(
	'成功绑定xx账号',
);
?>
&nbsp;
<h1>成功绑定xx账号</h1>
<br/>
<!--<h3 style="color:red;">恭喜！你已经失败绑定YY账号了游戏，开始你与众不同的大侠之路吧！</h3>-->

<?php if ($model) { ?>
<h3 style="color:red;">请牢记您的xx账号: <?php echo($model->account)?> </h3>
<?php } ?>

