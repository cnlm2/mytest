<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
&nbsp;
<h1>错误 <?php echo $code; ?></h1>
&nbsp;
<div class="error">
<?php echo CHtml::encode($message); ?>
</div>
