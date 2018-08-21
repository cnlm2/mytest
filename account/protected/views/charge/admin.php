<?php
/* @var $this ChargeController */
/* @var $model Charge */

$this->breadcrumbs=array(
	'Charges'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Charge', 'url'=>array('index')),
	array('label'=>'Create Charge', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#charge-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
&nbsp;
<h1>Manage Charges</h1>
&nbsp;
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'charge-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'no',
		'account_id',
		'fee',
		'status',
		'time',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
