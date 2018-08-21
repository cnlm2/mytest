
<?php

$this->breadcrumbs=array(
	'用户'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'密码重置',
);

$this->menu=array();
?>
&nbsp;
<!--
<h1>重置密码</h1>
-->
<h3><strong class="title-9">登录</strong></h3>
&nbsp;
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/js/md5.js"></script>
<script type="text/javascript">
<!--
$(document).ready(function() {
jQuery('input[type="text"]').addClass('inputText');
jQuery('input[type="password"]').addClass('inputPassword');
jQuery('input[type="submit"]').addClass('inputSubmit');
});
// -->
</script>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'account-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">带<span class="required">*</span>号的是必填项。</p>

	<?php echo $form->errorSummary($model); ?>

	<table>

	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'account'); ?></td>
		<td class="finput"><div>
		<?php echo $model->account; ?>
		</div></td>
		<td class="fnote"> </td>
	</tr>

	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'password'); ?></td>
		<td class="finput"><div>
		<?php echo $form->passwordField($model,'password',array('size'=>50,'maxlength'=>50)); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'password'); ?>
			<?php echo $form->error($model,'originpassword'); ?>
		</td>
	</tr>

	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'confirm'); ?></td>
		<td class="finput"><div>
		<?php echo $form->passwordField($model,'confirm',array('size'=>50,'maxlength'=>50)); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'confirm'); ?>
		</td>
	</tr>

	</table>

	<div class="row buttons">
		<?php echo CHtml::submitButton('重置'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
