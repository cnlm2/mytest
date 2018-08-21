<?php
$this->pageTitle=Yii::app()->name . ' - 防沉迷验证';
$this->breadcrumbs=array(
	'防沉迷验证',
);
?>
&nbsp;
<h1>防沉迷验证</h1>
<br/>

<script type="text/javascript">
<!--
jQuery(document).ready(function() {
jQuery('input[type="text"]').addClass('inputText');
jQuery('input[type="password"]').addClass('inputPassword');
jQuery('input[type="submit"]').addClass('inputSubmit');
});
// -->
</script>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'account-form',
	'enableAjaxValidation'=>true,
	'stateful'=>true,
	'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<table>
	<tr class="row">
		<td class="flabel">
		<?php echo $form->labelEx($model,'name'); ?>
		</td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'name',array('size'=>40)); ?>
		</div></td>
		<td class="fnote">
		<?php echo $form->error($model,'name'); ?>
		</td>
	</tr>

	<tr class="row">
		<td class="flabel">
		<?php echo $form->labelEx($model,'idcard'); ?>
		</td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'idcard',array('size'=>40)); ?>
		</div></td>
		<td class="fnote">
		<?php echo $form->error($model,'idcard'); ?>
		</td>
	</tr>
	</table>

	<div class="row buttons">
		<?php echo CHtml::submitButton('验证'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

