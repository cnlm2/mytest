<?php

$this->pageTitle=Yii::app()->name . ' - 卡号生成';
$this->breadcrumbs=array(
	'卡号生成',
);
?>
&nbsp;
<h1>卡号生成</h1>
&nbsp;
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cardgen-form',
)); ?>

	<p class="note">带 <span class="required">*</span> 是必填项.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<p class="note">卡号的种类：
			<li>15元充值卡：charge15</li>		
			<li>30元充值卡：charge30</li>		
			<li>媒体新手卡：media</li>		
		</p>
		<?php echo $form->textField($model,'type'); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<p class="note">跟踪标签，如:sina，163等等 </p>
		<?php echo $form->textField($model,'tags'); ?>
		<?php echo $form->error($model,'tags'); ?>
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

