<?php
/* @var $this AccountController */
/* @var $model Account */

$this->breadcrumbs=array(
	'用户'=>array('index'),
	'注册',
);

//$this->menu=array(
//	array('label'=>'用户列表', 'url'=>array('index')),
//	array('label'=>'管理用户', 'url'=>array('admin')),
//);
?>
&nbsp;
<h1>注册用户</h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
