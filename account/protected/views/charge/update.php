<?php
/* @var $this ChargeController */
/* @var $model Charge */

$this->breadcrumbs=array(
	'Charges'=>array('index'),
	$model->no=>array('view','id'=>$model->no),
	'Update',
);

$this->menu=array(
	array('label'=>'List Charge', 'url'=>array('index')),
	array('label'=>'Create Charge', 'url'=>array('create')),
	array('label'=>'View Charge', 'url'=>array('view', 'id'=>$model->no)),
	array('label'=>'Manage Charge', 'url'=>array('admin')),
);
?>

<h1>Update Charge <?php echo $model->no; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
