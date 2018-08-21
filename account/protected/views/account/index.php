<?php
/* @var $this AccountController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'用户',
);

$this->menu=array(
	array('label'=>'注册用户', 'url'=>array('create')),
	//array('label'=>'管理用户', 'url'=>array('admin')),
	array('label'=>'账号安全', 'url'=>array('update')),
);
?>

<h1>用户</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
