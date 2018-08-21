<?php
$this->pageTitle=Yii::app()->name . ' - 取得激活码';
$this->breadcrumbs=array(
	'取得激活码',
);
?>

<?php if($model->key) { ?>
&nbsp;
<h1>取得激活码</h1>
<br/>
<h3>恭喜！你已经成功取得了如下激活码，请复制激活码保存或者直接点击链接激活游戏：</h3>
<h4 style="color:red;font-weight:bold;"><?php echo $model->key;?></h4>
<?php echo CHtml::link("激活游戏", '#', array(
	'submit'=>array('site/activate'),
	'params'=>array('ActivateForm[key]'=>$model->key)
)); ?>
<?php } else { ?>
<h3>对不起！您这次没有获得激活码。</h3>
<?php } ?>

