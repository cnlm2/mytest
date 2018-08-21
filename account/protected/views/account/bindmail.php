<?php
/* @var $this AccountController */
/* @var $model Account */

$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/jqui/jquery-ui-1.9.2.custom.min.css');

$this->breadcrumbs=array(
	'用户'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'修改',
);

$this->initMenu();
$formatter = new ShadowFormatter();
?>
<h3><strong class="title-2">帐号安全</strong></h3>
<?php //echo $this->renderPartial('_form', array('model'=>$model)); ?>

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

<?php if ($model->verified == 0 && !$model->isNewrecord) { ?>
	<p class="note">带<span class="required">*</span>号的是必填项。</p>
<?php } ?>
	<?php echo $form->errorSummary($model); ?>

&nbsp;
	
	<?php
	$oldemail = $model->getOldEmail();
	if ($oldemail == Null || $oldemail == "" || $model->verified == 0) {?>

	<table>
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'account'); ?></td>
		<td class="finput"><div>
		<?php if ($model->isNewrecord) {
			echo $form->textField($model,'account',array('size'=>50,'maxlength'=>50));
		} else {
			echo CHtml::encode($model->account);
		}
		?>
		</div></td>
		<td class="fnote">
		<?php if ($model->isNewrecord) { ?>
			<?php echo $form->error($model,'account'); ?>
			用户名必须以英文字母开头，只能含有字母和数字。
		<?php } ?>
		</td>
	</tr>

	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'email'); ?></td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'email'); ?>
			请填写安全邮箱，用于密码找回。一旦填写并验证后将不可以修改。
		</td>
	</tr>
	</table>
	<?php echo CHtml::submitButton('验证'); ?>
<?php } ?>

<?php $this->endWidget(); ?>

</div><!-- form -->
