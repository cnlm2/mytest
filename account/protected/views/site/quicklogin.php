<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/js/md5.js"></script>
<script type="text/javascript">

function doSubmit()
{
	var password = document.getElementById("LoginForm_password");
	var pass = document.getElementById("LoginForm_pass");
	pass.value = hex_md5(password.value);
	password.value = "";
	AjaxPostLogin();
	return true;
}

jQuery(document).ready(function() {
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

});
</script>
<div id=content class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
    	'enableAjaxValidation'=>false,
		'stateful'=>true,
		'htmlOptions'=>array('enctype' => 'multipart/form-data'),

    )); ?>
    <?php if (Yii::app()->user->getState('info')) { ?>
        <div style="color:red"><?php echo Yii::app()->user->getState('info'); ?></div>
        <?php Yii::app()->user->setState('info', Null); ?>
    <?php } ?>
    <table>
        <tr class="row">
            <td class="flabel">
                <?php echo $form->labelEx($model,'username'); ?>
            </td>
            <td class="finput"><div>
                    <?php echo $form->textField($model,'username'); ?>
                </div></td>
			<td class="fnote"><div class="notecontent">
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
			<td class="fnote"><div class="notecontent">
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
			<td class="fnote"><div class="notecontent">
			<?php echo $form->error($model,'verifyCode'); ?>
			</div></td>
		</tr>

<?php echo $form->hiddenField($model, 'rememberMe'); ?>
<?php
if(!Yii::app()->request->isPostRequest) {
    Yii::app()->clientScript->registerScript(
        'initCaptcha',
        '$("#captcha").trigger("click");',
        CClientScript::POS_READY);
}
?>
</table>
<br>
<div>
    <div id="submitbutton">
        <a href="#" id="submit_button_login" onclick="return doSubmit();">登录</a>
    </div>
</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
