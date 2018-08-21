<?php

$this->pageTitle=Yii::app()->name . ' - 激活码生成';
$this->breadcrumbs=array(
	'激活码生成',
);
?>
&nbsp;
<h1>激活码生成</h1>
&nbsp;
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'keygen-form',
	'enableClientValidation'=>false,
)); ?>

	<p class="note">带 <span class="required">*</span> 是必填项.</p>
	<p class="note">盖世豪侠官网用激活码的说明必须以"official"开头（不含引号)。</p>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textField($model,'comment'); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'number'); ?>
		<?php echo $form->textField($model,'number'); ?>
		<?php echo $form->error($model,'number'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('生成'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
