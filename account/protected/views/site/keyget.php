<?php

$this->pageTitle=Yii::app()->name . ' - 答题抽码';
$this->breadcrumbs=array(
	'答题抽码',
);
?>
&nbsp;
<h1>回答下面问题领取激活码:</h1>
&nbsp;
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'keyget-form',
)); ?>

	<?php foreach($model->questions as $question) { ?>

		<div class="compactRadioGroup">
		<label class="title"><?php echo $question["desc"]; ?></label>
		<div class="answers">
		<?php echo $form->radioButtonList($model,"answer{$question["no"]}", $question["answers"]); ?>
		<?php echo $form->error($model,"answer{$question["no"]}"); ?>
		</div>
		</div>
	<!--div class="row">
	</div-->

	<?php } ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('领取'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

