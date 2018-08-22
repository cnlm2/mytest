<?php
/* @var $this AccountController */
/* @var $model Account */
/* @var $form CActiveForm */
$formatter = new ShadowFormatter();
?>

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

<h1>注册用户</h1>
	<p class="note">带<span class="required">*</span>号的是必填项。</p>
	<?php echo $form->errorSummary($model); ?>

&nbsp;
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

	<?php if ($model->isNewrecord) { ?>
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'password'); ?></td>
		<td class="finput"><div>
		<?php echo $form->passwordField($model,'password',array('size'=>50,'maxlength'=>50)); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'password'); ?>
			<?php echo $form->error($model,'originpassword'); ?>
			密码必须是长度在6到12位的字母，数字和符号的组合。并且<span class="required">不要</span>使用和安全邮箱一致的密码。
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
	
	<tr class="row">
		<td class="flabel"><?php echo $form->label($model,'verifyCode'); ?></td>
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
		<td class="fnote"><div class="notecontent">
		点击更换，不区分大小写
		<?php echo $form->error($model,'verifyCode'); ?>
		</div></td>
	</tr>
<?php
	Yii::app()->clientScript->registerScript(
		'initCaptcha',
		'$("#captcha").trigger("click");',
		CClientScript::POS_READY);
	
?>
<?php
} // isverified
?>
<?php if ($model->isNewRecord) { ?>
	<tr class="row">
		<td class="fagree" colspan="2"><div>
		<?php echo $form->checkBox($model,'isagree',array('checked'=>'checked')); ?>
		我已经阅读并同意<a href="/content/article-yhxy.html" target="_blank">用户服务协议</a>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'mobile'); ?>
		</td>
	</tr>
<?php } ?>
	</table>

	<div class="row buttons">
		<?php
		if ($model->isNewRecord) {

			echo CHtml::submitButton('注册', array(
				'id'=>'reg_button',
				'encode'=>false,
				'onclick'=>"_hmt.push(['_trackEvent','register','normal','']);"
			));
			
		} else {
			echo CHtml::submitButton('保存');
		}
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
