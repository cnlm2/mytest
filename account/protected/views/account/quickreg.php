<?php
/* @var $this AccountController */
/* @var $model Account */
/* @var $form CActiveForm */

//Yii::app()->clientScript->registerCoreScript('jquery');

//Yii::app()->clientScript->scriptMap['jquery.js'] = false;
//Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;

?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/js/md5.js"></script>

<div id="content" class="form">
<?php
//Yii::import('application.vendors.*');

//require_once('ipinfo.php');
//$ip = $_SERVER["REMOTE_ADDR"];
//$ipinfo = GetIpInfo($ip);
//if ($ipinfo['city'] === "广州市") {
if (false) {
?>
<p style="color:red;font-weight:bold;margin-top:50px;margin-left:50px;font-size:20px;">功能尚未开放</p>
<?php
} else {

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'account-form',
	'enableAjaxValidation'=>true,
	'stateful'=>true,
	'htmlOptions'=>array('enctype' => 'multipart/form-data'),
));
CHtml::$afterRequiredLabel='';
?>
<table>
	<tr class="row">
		<td class="flabel fabel_01"><?php echo $form->labelEx($model,'account'); ?>：</td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'account',array('size'=>50,'maxlength'=>50,'placeholder'=>"6-16位字母数字组成账号")); ?>
		</div></td>
		<td class="fnote"><div class="notecontent">
		<?php echo $form->error($model,'account'); ?>
		</div></td>
	</tr>

	<tr class="row">
		<td class="flabel flabel_02"><?php echo $form->labelEx($model,'password'); ?>：</td>
		<td class="finput"><div>
		<?php echo $form->passwordField($model,'password',array('size'=>50,'maxlength'=>50,'placeholder'=>"密码长度6-16个字符")); ?>
		</div></td>
		<td class="fnote"><div class="notecontent">
			<?php echo $form->error($model,'password'); ?>
			<?php echo $form->error($model,'originpassword'); ?>
		</div></td>
	</tr>

	<tr class="row">
		<td class="flabel flabel_03"><?php echo $form->labelEx($model,'confirm'); ?>：</td>
		<td class="finput"><div>
		<?php echo $form->passwordField($model,'confirm',array('size'=>50,'maxlength'=>50,'placeholder'=>"再次输入密码")); ?>
		</div></td>
		<td class="fnote"><div class="notecontent">
			<?php echo $form->error($model,'confirm'); ?>
		</div></td>
	</tr>
	<!--
	<tr class="row">
		<td class="flabel"><?php echo $form->label($model,'verifyCode'); ?>：</td>
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
		<?php echo $form->textField($model,'verifyCode', array('style'=>'width:80px')); ?>
		</div></td>
		<td class="fnote"><div class="notecontent">
		<?php echo $form->error($model,'verifyCode'); ?>
		</div></td>
	</tr>
<?php
	Yii::app()->clientScript->registerScript(
		'initCaptcha',
		'$("#captcha").trigger("click");',
		CClientScript::POS_READY);
	
?>
-->
	<tr class="row">
		<td></td>
		<td class="fagree" colspan="1"><div>
		<?php echo $form->checkBox($model,'isagree',array('checked'=>'checked')); ?>
		我已阅读并同意<a href="/content/article-yhxy.html" target="_blank">用户协议</a>
		</div></td>
		<td class="fnote"><div class="notecontent" style="top:15px;left:-150px">
			<?php echo $form->error($model,'isagree'); ?>
		</div></td>
	</tr>
</table>
<div>
	<div id="submitbutton" style="margin-top:4px;margin-left:30px;">
		<?php echo CHtml::submitButton('立即注册', array(
			'id'=>'submit_button',
			'encode'=>false,
			'onclick'=>"return AjaxPostRegister();",
		)); ?>
	</div>
</div>
<?php $this->endWidget();
}
?>
</div><!-- form -->

<script type="text/javascript">
	<!--
	//jQuery(document).ready(function() {
		jQuery('input[type="text"]').addClass('inputText');
		jQuery('input[type="password"]').addClass('inputPassword');
		jQuery('input[type="submit"]').addClass('inputSubmit');
		jQuery(".errorMessage").mouseenter(function() {
			$(this).text("");
		});
		jQuery("input").focus(function() {
			jQuery(".errorMessage").text("");
			$(this).parent().removeClass('error');
		});
	//});
	// -->
</script>
