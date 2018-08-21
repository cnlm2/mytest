<?php
/* @var $this AccountController */
/* @var $model Account */

$this->breadcrumbs=array(
	'用户'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'修改',
);
$this->initMenu();
?>
<h3><strong class="title-3">修改密码</strong></h3>

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
	'enableAjaxValidation'=>true,
	'stateful'=>true,
	'htmlOptions'=>array('enctype' => 'multipart/form-data'),
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
		<td class="flabel"><?php echo $form->labelEx($model,'oldpassword'); ?></td>
		<td class="finput"><div>
		<?php echo $form->passwordField($model,'oldpassword',array('size'=>50,'maxlength'=>50)); ?>
		</div></td>
		<td class="fnote">
			请<span class="required">不要</span>使用和安全邮箱一致的密码
			<?php echo $form->error($model,'oldpassword'); ?>
		</td>
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
		<?php echo CHtml::submitButton('修改'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
