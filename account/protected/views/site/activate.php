<?php
$this->pageTitle=Yii::app()->name . ' - 激活游戏';
$this->breadcrumbs=array(
	'激活游戏',
);
?>
&nbsp;
<h1>激活游戏</h1>
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
	'id'=>'activate-form',
	'enableClientValidation'=>false,
)); ?>

<table>
	<tr class="row">
		<td class="flabel">
		<?php echo $form->labelEx($model,'key'); ?>
		</td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'key',array('size'=>40)); ?>
		</div></td>
		<td class="fnote">
		<?php echo $form->error($model,'key'); ?>
		</td>
	</tr>
</table>

	<div class="row buttons">
		<?php echo CHtml::submitButton('激活'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

