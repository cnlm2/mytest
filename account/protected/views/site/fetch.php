<?php
$this->pageTitle=Yii::app()->name . ' - 密码找回';
$this->breadcrumbs=array(
	'密码找回',
);
?>

<script type="text/javascript">
<!--
jQuery(document).ready(function() {
jQuery('input[type="text"]').addClass('inputText');
jQuery('input[type="password"]').addClass('inputPassword');
jQuery('input[type="submit"]').addClass('inputSubmit');
});
// -->
</script>
<h3><strong class="title-9">登录</strong></h3>
&nbsp;
<!--
&nbsp;
<h1>密码找回</h1>
&nbsp;
-->
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'fetch-password-form',
)); ?>

<table>
	<tr class="row">
		<td class="flabel">
			<?php echo $form->labelEx($model,'account'); ?>
		</td>
		<td class="finput"><div>
			<?php echo $form->textField($model,'account'); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'account'); ?>
		</td>
	</tr>
</table>

	<div class="row buttons">
		<?php echo CHtml::submitButton('提交')?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

