<?php
/* @var $this AccountController */
/* @var $model Account */

$this->breadcrumbs=array(
	'用户'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'抽奖',
);

$this->initMenu();
?>
&nbsp;
<h1></h1>
&nbsp;
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/gq.css" />
<div class="gqreward">
<?php echo $this->renderPartial('_rewardinfo', array('info'=>$info,'model'=>$model,'key'=>$key)); ?>
</div>

