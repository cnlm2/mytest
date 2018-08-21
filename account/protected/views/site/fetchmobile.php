<?php
$this->pageTitle=Yii::app()->name . ' - 密码找回';
$this->breadcrumbs=array(
	'密码找回',
);
?>
<script type="text/javascript">

jQuery(document).ready(function() {
jQuery('input[type="text"]').addClass('inputText');
jQuery('input[type="password"]').addClass('inputPassword');
jQuery('input[type="submit"]').addClass('inputSubmit');

var timeout = 0
var timer;
var mobile;
$("#getkey").click(function(){
	if (timeout > 0) {
		return;
	}
	var account = $("#FetchPasswordMobileForm_account").val();
	$.get("/account/index.php/site/sendverifyphone?id="+account,function(jstr) {
		var data  = eval('('+ jstr +')');
		var res = data['res'];
		if (res == 0) {
			mobile = data['mobile'];
			$("#getkey").text("已发送至安全手机 " + mobile );
			/*
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
				$("#getkey").text("已发送至安全手机" + mobile +" " + timeout);
			},1000)
			*/
		} else if( res == -1 ) {
			website.popopen("#mzdialog1")
		}
	});
});
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
	'id'=>'fetch-password-mobile-form',
	'enableAjaxValidation'=>true,
	'stateful'=>true,
	'htmlOptions'=>array('enctype' => 'multipart/form-data'),
));
?>
<?php if (Yii::app()->user->getState('info')) { ?>

<p style="color:red"><?php echo Yii::app()->user->getState('info'); ?>
<?php Yii::app()->user->setState('info', Null); } ?>

<?php echo $form->errorSummary($model); ?>

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

	<div class="row buttons">
		<?php echo CHtml::submitButton('提交')?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

