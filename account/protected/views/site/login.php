<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - 登录';
$this->breadcrumbs=array(
	'登录',
);
?>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/js/md5.js"></script>
<script type="text/javascript">
<!--
function doSubmit()
{
	var form = document.getElementById("login-form");
	var password = document.getElementById("LoginForm_password");
	var pass = document.getElementById("LoginForm_pass");
	pass.value = hex_md5(password.value);
	password.value = "";
	form.submit();
	return true;
}
jQuery(document).ready(function() {
	jQuery('input[type="text"]').addClass('inputText');
	jQuery('input[type="password"]').addClass('inputPassword');
	jQuery('input[type="submit"]').addClass('inputSubmit');
});
// -->
</script>
<!--
&nbsp;
<h1>登录</h1>
-->
<h3><strong class="title-8">登录</strong></h3>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
)); ?>
	<p class="note">带 <span class="required">*</span> 是必填项.</p>
<?php if (Yii::app()->user->getState('info')) { ?>
<div style="color:red"><?php echo Yii::app()->user->getState('info'); ?></div>
<?php Yii::app()->user->setState('info', Null); ?>
<?php } else { ?>
<p>请在下面表单里填写认证信息:</p>
<?php } ?>

<table>
	<tr class="row">
		<td class="flabel">
			<?php echo $form->labelEx($model,'username'); ?>
		</td>
		<td class="finput"><div>
			<?php echo $form->textField($model,'username'); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'username'); ?>
		</td>
	</tr>

	<tr class="row">
		<td class="flabel">
		<?php echo $form->labelEx($model,'password'); ?>
		</td>
		<td class="finput"></div>
		<?php echo $form->passwordField($model,'password'); ?>
		</div></td>
		<td class="fnote">
		<?php echo $form->error($model,'password'); ?>
		<?php echo $form->hiddenField($model,'pass'); ?>
		</td>
	</tr>

	<tr class="row">
		<td class="flabel">
		<?php echo $form->label($model,'verifyCode'); ?>
		</td>
		<td class="finput"><div>
		<a href="#">
		<?php $this->widget('CCaptcha', array(
			'clickableImage'=>true,
			'showRefreshButton'=>false,
			'imageOptions'=>array(
				'style'=>'float:right;',
				'id'=>'captcha',
			),
		)); ?></a>
		<?php echo $form->textField($model,'verifyCode', array('style'=>'width:100px')); ?>
		</div></td>
		<td class="fnote">
		点击更换，不区分大小写
		<?php echo $form->error($model,'verifyCode'); ?>
		</td>
	</tr>

<?php
	if(!Yii::app()->request->isPostRequest) {
		Yii::app()->clientScript->registerScript(
			'initCaptcha',
			'$("#captcha").trigger("click");',
			CClientScript::POS_READY);
	}
?>

	<tr class="row rememberMe">
		<td class="flabel">
		<?php echo $form->label($model,'rememberMe'); ?>
		</td>
		<td class="finput"><div>
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		</div></td>
		<td class="fnote">
		<?php echo $form->error($model,'rememberMe'); ?>
		</td>
	</tr>
</table>

	<div class="row buttons">
		<?php echo CHtml::submitButton('登录', array(
				"onclick"=>"return doSubmit();"
		)); ?>
		&nbsp;<b><?php echo CHtml::link("立即注册", array('account/create'));?></b>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

