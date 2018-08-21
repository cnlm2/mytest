<?php
/* @var $this AccountController */
/* @var $model Account */

$this->breadcrumbs=array(
	'用户'=>array('index'),
	'开通论坛',
);
$this->initMenu();
?>
<!--
&nbsp;
<h1>开通论坛</h1>
&nbsp;
-->
<h3><strong class="title-10">开通论坛</strong></h3>

<script type="text/javascript">
<!--
$(document).ready(function() {
jQuery('input[type="text"]').addClass('inputText');
jQuery('input[type="password"]').addClass('inputPassword');
jQuery('input[type="submit"]').addClass('inputSubmit');
});
// -->
</script>

&nbsp;
<?php if (Yii::app()->user->getState('info')) { ?>
<p style="color:red"><?php echo Yii::app()->user->getState('info'); ?> </p>
<?php Yii::app()->user->setState('info', Null); } ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'account-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">带<span class="required">*</span>号的是必填项。</p>

	<?php echo $form->errorSummary($model); ?>

	<table>

	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'nickname'); ?></td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'nickname',array('size'=>50,'maxlenght'=>50));?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'nickname'); ?>
		</td>
	</tr>

	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'originpassword'); ?></td>
		<td class="finput"><div>
		<?php echo $form->passwordField($model,'originpassword',array('size'=>50,'maxlength'=>50)); ?>
		</div></td>
		<td class="fnote">
			请输入您的账号密码
			<?php echo $form->error($model,'oldpassword'); ?>
		</td>
	</tr>

	</table>

	<div class="row buttons">
		<?php echo CHtml::submitButton('开通'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
