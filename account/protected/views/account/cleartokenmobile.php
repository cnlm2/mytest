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

var timeout = 0
var timer;
$("#getkey").click(function(){
	if (timeout > 0) {
		return;
	}
	$.get("/account/index.php/account/sendverifyphone",function(jstr) {
		var data  = eval('('+ jstr +')');
		var res = data['res'];
		if (res==0) {
			timeout = 120;
			timer = setInterval(function(){
				timeout = timeout - 1;
				if (timeout < 0) {
					clearInterval(timer);
					$("#getkey").text("点击获取验证码");
					$("#getkey").attr({ "href": "javascript:void(0)" });
					return;
				}
				$("#getkey").removeAttr("href");
				$("#getkey").text("已发送"+timeout);
			},1000)
		} else if (res == -1) {
			website.popopen("#mzdialog1")
		}
	});
});
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
<?php if ($model->verified == 0 && !$model->isNewrecord) { ?>
<?php } ?>
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
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'verifiedmobile'); ?></td>
		<td class="finput"><div>
		<?php echo CHtml::encode($model->verifiedmobile); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'verifiedmobile'); ?>
		</td>
	</tr>
	
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'verifyCode'); ?></td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'verifyCode', array('style'=>'width:100px')); ?>
		</div></td>
		<td class="fnote">
			<a id="getkey" href="javascript:void(0);">点击获取验证码</a>
		</td>
	</tr>
	</table>
	<?php echo CHtml::submitButton('验证'); ?>
<?php $this->endWidget(); ?>

</div><!-- form -->
