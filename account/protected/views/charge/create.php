<?php
/* @var $this ChargeController */
/* @var $model Charge */

$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/jqui/jquery-ui-1.9.2.custom.min.css');

$this->breadcrumbs=array(
	'充值'=>array('index'),
	'创建订单',
);

$this->initMenu();
$YuanBaoMultiple = $this->getCurrentRate();
$DiscountInfo = "2014年3月21日-2014年3月27日期间充值，可额外获得10%的点数奖励";
?>
<h3><strong class="title-6">帐户充值</strong></h3>
&nbsp;
<!--
&nbsp;
<h1>账户充值</h1>
&nbsp;
-->
<script type="text/javascript">
<!--

function sync() {
	var changeditem = $(this);
	$('input[type="radio"].fee_sel').each(function() {
		$(this).prop('checked',false);
		if ($(this).val() == changeditem.val()) {
			$(this).prop('checked',true);
		}
	});
	$('.yuanbao').text($(this).val()*<?php echo $YuanBaoMultiple?>);
	$('.feeval').val($(this).val());
}
$(document).ready(function() {
	$('input[type="text"]').addClass('inputText');
	$('input[type="password"]').addClass('inputPassword');
	$('input[type="submit"]').addClass('inputSubmit');
	$('input[type="radio"].fee_sel').change(function() {
		var changeditem = $(this);
		$('input[type="radio"].fee_sel').each(function() {
			if ($(this).val() == changeditem.val()) {
				$(this).prop('checked',true);
			}
		});
		$('.feeval').val($(this).val());
		$('.yuanbao').text($(this).val()*<?php echo $YuanBaoMultiple?>);
	});
	$('.feeval').keyup(sync);
	$(".bankname a").click(function(event) {
		$(event.target).prev().prop('checked', true);
		return false;
	})
	$(function() {
		$("#tabs").tabs();
	});
	$('SELECT[name="Charge[server_id]"]').each(function(i){
		$(this).change(function(){
			var server_id = $(this).val();
			if (server_id == 0) {
				return;
			}
			var prefix = "#tabs-"+(i+1)+" ";
			var account =$(prefix+"#Charge_account_name").val();
			if (!account) {
				return;
			}
			$.get("/account/index.php/account/idlist?server_id="+server_id+"&account="+account, function(data) {
				var res = eval('('+ data +')');
				if (res['res_code']==0) {
					$(prefix+"#Charge_char_id").empty();
					$("<option value=0>请选择角色名</option>").appendTo($(prefix+"#Charge_char_id"));
					var idlist = res['idlist'];
					for (var i in idlist) {
						var account = idlist[i];
						$("<option value=" + account['Id'] + ">" + account['Name'] + "</option>").appendTo($(prefix+"#Charge_char_id"));
					}
				}
			});
		});
	});
});

function showConfirm(id) {
	var prefix = "#tabs-"+id+" ";
	$('.feeval').each(sync);
	$(".confirm #account").text($(prefix+"#Charge_account_name").val());
	$(".confirm #char").text($(prefix+"#Charge_char_id option:selected").text());
	$(".confirm #fee").text($(prefix+"#Charge_fee").val());
	$("#confirm").dialog({
		resizable: false,
		height: 200,
		modal: true,
		buttons: {
			"确认": function() {
				$(this).dialog("close");
				$(prefix+"#charge-form"+id).submit();
			},
			"取消": function() {
				$(this).dialog("close");
			}
		}
	});
}

// -->
</script>
<style>
div.bankname { margin: 4px; width: 160px; height: 32px; float: left; }
div.bankname input { float: left; width: 20px; height: 20px;}
div.bankname a { display:block; float: left; width: 132px; height: 32px; text-indent: -9999px;}
a#bank001 { background: url(/images/banks.png) no-repeat 0px 0px; }
a#bank002 { background: url(/images/banks.png) no-repeat 0px -40px; }
a#bank003 { background: url(/images/banks.png) no-repeat 0px -80px; }
a#bank004 { background: url(/images/banks.png) no-repeat 0px -120px; }
a#bank005 { background: url(/images/banks.png) no-repeat 0px -160px; }
a#bank006 { background: url(/images/banks.png) no-repeat 0px -200px; }
a#bank007 { background: url(/images/banks.png) no-repeat 0px -240px; }
a#bank008 { background: url(/images/banks.png) no-repeat 0px -278px; }
a#bank009 { background: url(/images/banks.png) no-repeat 0px -316px; }
a#bank010 { background: url(/images/banks.png) no-repeat 0px -354px; }
a#bank011 { background: url(/images/banks.png) no-repeat 0px -397px; }
a#bank012 { background: url(/images/banks.png) no-repeat 0px -433px; }
a#bank013 { background: url(/images/banks.png) no-repeat 0px -475px; }
a#bank014 { background: url(/images/banks.png) no-repeat 0px -512px; }
a#bank020 { background: url(/images/banks.png) no-repeat 0px -551px; }
<?php
//a#bank015 { background: url(/images/banks.png) no-repeat 0px -560px; }
//a#bank016 { background: url(/images/banks.png) no-repeat 0px -600px; }
//a#bank017 { background: url(/images/banks.png) no-repeat 0px -640px; }
//a#bank018 { background: url(/images/banks.png) no-repeat 0px -680px; }
//a#bank019 { background: url(/images/banks.png) no-repeat 0px -720px; }
//a#bank024 { background: url(/images/banks.png) no-repeat 0px -800px; }
?>
</style>

<div class="confirm" id="confirm" title="充值信息确认" style="display:none;">
	<p>您将要进行充值的账号：<span id="account"></span></p>
	<p>充值角色：<span id="char"></span></p>
	<p>充值金额：<span id="fee"></span></p>
	<p>获得元宝：<span class="yuanbao"><?php echo 100*$YuanBaoMultiple?></span></p>
</div>

<div id="tabs">
  <ul>
    <li><a href="#tabs-5">银行卡</a></li>
    <li><a href="#tabs-1">支付宝</a></li>
    <li><a href="#tabs-6">微 信</a></li>
    <li><a href="#tabs-2">移动卡</a></li>
    <li><a href="#tabs-3">联通卡</a></li>
    <li><a href="#tabs-4">电信卡</a></li>
  </ul>
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
<div id="tabs-1"><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'charge-form1',
	'enableAjaxValidation'=>true,
)); ?>
<?php if ($YuanBaoMultiple > 10) { ?>
	<p class="note"><span class="required"><?php echo $DiscountInfo?></span></p>
<?php } ?>
	<p class="note">带<span class="required">*</span>号的是必填项。</p>
	<?php echo $form->errorSummary($model); ?>
	<table>
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'account_name'); ?></td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'account_name'); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'account_name'); ?>
			充值的目标账户
		</td>
	</tr>
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'char_id'); ?></td>
		<td class="finput"><div>
			<?php echo $form->dropDownList($model,'server_id',$serverList); ?>
			<?php echo $form->dropDownList($model,'char_id',array(0=>'请选择角色')); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'char_id'); ?>
			充值的目标角色
		</td>
	</tr>
	<!--
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'account_confirm'); ?></td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'account_confirm'); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'account_confirm'); ?>
			目标账户确认
		</td>
	</tr>
	-->
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'fee'); ?></td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'fee', array('class'=>'feeval','value'=>100)); ?>
		</div></td>
		<td class="fnote"> 
			<?php echo $form->error($model,'fee'); ?>
			这里可以直接输入自定义金额
		</td>
	</tr>
	<tr class="row">
		<td class="flabel">请选择</td>
		<td class="finput" colspan="2"><div>
		<input class="fee_sel" type="radio" name="radio" value="10"/>10
		<input class="fee_sel" type="radio" name="radio" value="20"/>20
		<input class="fee_sel" type="radio" name="radio" value="50"/>50
		<input class="fee_sel" type="radio" name="radio" value="100" checked/>100
		<input class="fee_sel" type="radio" name="radio" value="200"/>200
		<input class="fee_sel" type="radio" name="radio" value="500"/>500
		</div></td>
	</tr>
	<tr class="row">
		<td class="flabel">可获得元宝</td>
		<td class="finput"><div class="yuanbao" style="color:red;font-weight:bold;"><?php echo 100*$YuanBaoMultiple?></div></td>
		<td class="fnote"></td>
	</tr>
	</table>
	<?php echo $form->hiddenField($model, 'charge_type', array('value'=>"zfb")); ?>

	<div class="row buttons">
		<input type="button" class="inputSubmit" onclick="showConfirm(1);" value="充值"></input>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form --></div>
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
<div id="tabs-2"><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'charge-form2',
	'enableAjaxValidation'=>true,
)); ?>
<?php if ($YuanBaoMultiple > 10) { ?>
	<p class="note"><span class="required"><?php echo $DiscountInfo?></span></p>
<?php } ?>
	<p class="note">带<span class="required">*</span>号的是必填项。</p>
	<?php echo $form->errorSummary($model); ?>
	<table>
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'account_name'); ?></td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'account_name'); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'account_name'); ?>
			充值的目标账户
		</td>
	</tr>
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'char_id'); ?></td>
		<td class="finput"><div>
			<?php echo $form->dropDownList($model,'server_id',$serverList); ?>
			<?php echo $form->dropDownList($model,'char_id',array(0=>'请选择角色')); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'char_id'); ?>
			充值的目标角色
		</td>
	</tr>
	<!--
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'account_confirm'); ?></td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'account_confirm'); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'account_confirm'); ?>
			目标账户确认
		</td>
	</tr>
	-->
	<tr class="row">
		<td class="flabel">请选择</td>
		<td class="finput" colspan="2"><div>
		<input class="fee_sel" type="radio" name="radio" value="10"/>10
		<input class="fee_sel" type="radio" name="radio" value="20"/>20
		<input class="fee_sel" type="radio" name="radio" value="30"/>30
		<input class="fee_sel" type="radio" name="radio" value="50"/>50
		<input class="fee_sel" type="radio" name="radio" value="100" checked/>100
		<input class="fee_sel" type="radio" name="radio" value="300"/>300
		<input class="fee_sel" type="radio" name="radio" value="500"/>500
		</div></td>
	</tr>
	<tr class="row">
		<td class="fnote" colspan="3" style="color:red">重要提示：请务必使用与此面额相同的充值卡；否则会导致支付不成功，或支付金额丢失。</td>
	</tr>
	<tr class="row">
		<td class="flabel">可获得元宝</td>
		<td class="finput"><div class="yuanbao" style="color:red;font-weight:bold;"><?php echo 100*$YuanBaoMultiple?></div></td>
		<td class="fnote"><?php echo $form->error($model,'fee'); ?></td>
	</tr>
	</table>
	<?php echo $form->hiddenField($model,'fee', array('class'=>'feeval','value'=>100)); ?>
	<?php echo $form->hiddenField($model, 'charge_type', array('value'=>"yd")); ?>

	<div class="row buttons">
		<input type="button" class="inputSubmit" onclick="showConfirm(2);" value="充值"></input>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form --></div>
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
<div id="tabs-3"><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'charge-form3',
	'enableAjaxValidation'=>true,
)); ?>
<?php if ($YuanBaoMultiple > 10) { ?>
	<p class="note"><span class="required"><?php echo $DiscountInfo?></span></p>
<?php } ?>
	<p class="note">带<span class="required">*</span>号的是必填项。</p>
	<?php echo $form->errorSummary($model); ?>
	<table>
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'account_name'); ?></td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'account_name'); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'account_name'); ?>
			充值的目标账户
		</td>
	</tr>
	<!--
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'account_confirm'); ?></td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'account_confirm'); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'account_confirm'); ?>
			目标账户确认
		</td>
	</tr>
	-->
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'char_id'); ?></td>
		<td class="finput"><div>
			<?php echo $form->dropDownList($model,'server_id',$serverList); ?>
			<?php echo $form->dropDownList($model,'char_id',array(0=>'请选择角色')); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'char_id'); ?>
			充值的目标角色
		</td>
	</tr>
	<tr class="row">
		<td class="flabel">请选择</td>
		<td class="finput" colspan="2"><div>
		<input class="fee_sel" type="radio" name="radio" value="20"/>20
		<input class="fee_sel" type="radio" name="radio" value="30"/>30
		<input class="fee_sel" type="radio" name="radio" value="50"/>50
		<input class="fee_sel" type="radio" name="radio" value="100" checked/>100
		<input class="fee_sel" type="radio" name="radio" value="300"/>300
		<input class="fee_sel" type="radio" name="radio" value="500"/>500
		</div></td>
	</tr>
	<tr class="row">
		<td class="fnote" colspan="3" style="color:red">重要提示：请务必使用与此面额相同的充值卡；否则会导致支付不成功，或支付金额丢失。</td>
	</tr>
	<tr class="row">
		<td class="flabel">可获得元宝</td>
		<td class="finput"><div class="yuanbao" style="color:red;font-weight:bold;"><?php echo 100*$YuanBaoMultiple?></div></td>
		<td class="fnote"><?php echo $form->error($model,'fee'); ?></td>
	</tr>
	</table>
	<?php echo $form->hiddenField($model,'fee', array('class'=>'feeval','value'=>100)); ?>
	<?php echo $form->hiddenField($model, 'charge_type', array('value'=>"lt")); ?>

	<div class="row buttons">
		<input type="button" class="inputSubmit" onclick="showConfirm(3);" value="充值"></input>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form --></div>
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
<div id="tabs-4"><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'charge-form4',
	'enableAjaxValidation'=>true,
)); ?>
<?php if ($YuanBaoMultiple > 10) { ?>
	<p class="note"><span class="required"><?php echo $DiscountInfo?></span></p>
<?php } ?>
	<p class="note">带<span class="required">*</span>号的是必填项。</p>
	<?php echo $form->errorSummary($model); ?>
	<table>
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'account_name'); ?></td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'account_name'); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'account_name'); ?>
			充值的目标账户
		</td>
	</tr>
	<!--
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'account_confirm'); ?></td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'account_confirm'); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'account_confirm'); ?>
			目标账户确认
		</td>
	</tr>
	-->
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'char_id'); ?></td>
		<td class="finput"><div>
			<?php echo $form->dropDownList($model,'server_id',$serverList); ?>
			<?php echo $form->dropDownList($model,'char_id',array(0=>'请选择角色')); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'char_id'); ?>
			充值的目标角色
		</td>
	</tr>
	<tr class="row">
		<td class="flabel">请选择</td>
		<td class="finput" colspan="2"><div>
		<input class="fee_sel" type="radio" name="radio" value="10"/>10
		<input class="fee_sel" type="radio" name="radio" value="20"/>20
		<input class="fee_sel" type="radio" name="radio" value="30"/>30
		<input class="fee_sel" type="radio" name="radio" value="50"/>50
		<input class="fee_sel" type="radio" name="radio" value="100" checked/>100
		<input class="fee_sel" type="radio" name="radio" value="200"/>200
		<input class="fee_sel" type="radio" name="radio" value="300"/>300
		<input class="fee_sel" type="radio" name="radio" value="500"/>500
		</div></td>
	</tr>
	<tr class="row">
		<td class="fnote" colspan="3" style="color:red">重要提示：请务必使用与此面额相同的充值卡；否则会导致支付不成功，或支付金额丢失。</td>
	</tr>
	<tr class="row">
		<td class="flabel">可获得元宝</td>
		<td class="finput"><div class="yuanbao" style="color:red;font-weight:bold;"><?php echo 100*$YuanBaoMultiple?></div></td>
		<td class="fnote"><?php echo $form->error($model,'fee'); ?></td>
	</tr>
	</table>
	<?php echo $form->hiddenField($model,'fee', array('class'=>'feeval','value'=>100)); ?>
	<?php echo $form->hiddenField($model, 'charge_type', array('value'=>"dx")); ?>

	<div class="row buttons">
		<input type="button" class="inputSubmit" onclick="showConfirm(4);" value="充值"></input>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form --></div>
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
<div id="tabs-5"><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'charge-form5',
	'enableAjaxValidation'=>true,
)); ?>
<?php if ($YuanBaoMultiple > 10) { ?>
	<p class="note"><span class="required"><?php echo $DiscountInfo?></span></p>
<?php } ?>
	<p class="note">带<span class="required">*</span>号的是必填项。</p>
	<?php echo $form->errorSummary($model); ?>
	<table>
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'account_name'); ?></td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'account_name'); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'account_name'); ?>
			充值的目标账户
		</td>
	</tr>
	<!--
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'account_confirm'); ?></td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'account_confirm'); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'account_confirm'); ?>
			目标账户确认
		</td>
	</tr>
	-->
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'char_id'); ?></td>
		<td class="finput"><div>
			<?php echo $form->dropDownList($model,'server_id',$serverList); ?>
			<?php echo $form->dropDownList($model,'char_id',array(0=>'请选择角色')); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'char_id'); ?>
			充值的目标角色
		</td>
	</tr>
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'fee'); ?></td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'fee', array('class'=>'feeval','value'=>100)); ?>
		</div></td>
		<td class="fnote"> 
			<?php echo $form->error($model,'fee'); ?>
			这里可以直接输入自定义金额
		</td>
	</tr>
	<tr class="row">
		<td class="flabel">请选择</td>
		<td class="finput" colspan="2"><div>
		<input class="fee_sel" type="radio" name="radio" value="10"/>10
		<input class="fee_sel" type="radio" name="radio" value="20"/>20
		<input class="fee_sel" type="radio" name="radio" value="50"/>50
		<input class="fee_sel" type="radio" name="radio" value="100" checked/>100
		<input class="fee_sel" type="radio" name="radio" value="200"/>200
		<input class="fee_sel" type="radio" name="radio" value="500"/>500
		</div></td>
	</tr>
	<tr class="row">
		<td class="flabel" style="vertical-align:top;padding-top:5px;">请选择银行</td>
		<td class="finput" colspan="2"><div>
			<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="001" checked/><a id="bank001" href="#">中国工商银行</a></div>
			<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="002"/><a id="bank002" href="#">招商银行</a></div>
			<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="003"/><a id="bank003" href="#">中国建设银行</a></div>
			<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="004"/><a id="bank004" href="#">中国银行</a></div>
			<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="005"/><a id="bank005" href="#">中国农业银行</a></div>
			<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="006"/><a id="bank006" href="#">交通银行</a></div>
			<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="007"/><a id="bank007" href="#">上海浦东发展银行</a></div>
			<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="008"/><a id="bank008" href="#">广东发展银行</a></div>
			<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="009"/><a id="bank009" href="#">中信银行</a></div>
			<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="010"/><a id="bank010" href="#">中国光大银行</a></div>
			<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="011"/><a id="bank011" href="#">兴业银行</a></div>
			<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="012"/><a id="bank012" href="#">平安银行</a></div>
			<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="013"/><a id="bank013" href="#">中国民生银行</a></div>
			<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="014"/><a id="bank014" href="#">华夏银行</a></div>
			<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="020"/><a id="bank020" href="#">中国邮政储蓄银行</a></div>
<?php		
			//<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="015"/><a id="bank015" href="#">广州市商业银行</a></div>
			//<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="016"/><a id="bank016" href="#">深圳市农村商业银行</a></div>
			//<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="017"/><a id="bank017" href="#">上海市农村商业银行</a></div>
			//<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="018"/><a id="bank018" href="#">广州农村信用合作社</a></div>
			//<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="019"/><a id="bank019" href="#">广州银行</a></div>
			//<div class="bankname"><input class="bank" type="radio" name="Charge[bank]" value="024"/><a id="bank024" href="#">宁波银行</a></div>
?>
		</div></td>
	</tr>
	<tr class="row">
		<td class="flabel">可获得元宝</td>
		<td class="finput"><div class="yuanbao" style="color:red;font-weight:bold;"><?php echo 100*$YuanBaoMultiple?></div></td>
		<td class="fnote"><?php echo $form->error($model,'fee'); ?></td>
	</tr>
	</table>
	<?php echo $form->hiddenField($model, 'charge_type', array('value'=>"hfbbank")); ?>

	<div class="row buttons">
		<input type="button" class="inputSubmit" onclick="showConfirm(5);" value="充值"></input>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form --></div>
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
<div id="tabs-6"><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'charge-form6',
	'enableAjaxValidation'=>true,
)); ?>
<?php if ($YuanBaoMultiple > 10) { ?>
	<p class="note"><span class="required"><?php echo $DiscountInfo?></span></p>
<?php } ?>
	<p class="note">带<span class="required">*</span>号的是必填项。</p>
	<?php echo $form->errorSummary($model); ?>
	<table>
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'account_name'); ?></td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'account_name'); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'account_name'); ?>
			充值的目标账户
		</td>
	</tr>
	<!--
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'account_confirm'); ?></td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'account_confirm'); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'account_confirm'); ?>
			目标账户确认
		</td>
	</tr>
	-->
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'char_id'); ?></td>
		<td class="finput"><div>
			<?php echo $form->dropDownList($model,'server_id',$serverList); ?>
			<?php echo $form->dropDownList($model,'char_id',array(0=>'请选择角色')); ?>
		</div></td>
		<td class="fnote">
			<?php echo $form->error($model,'char_id'); ?>
			充值的目标角色
		</td>
	</tr>
	<tr class="row">
		<td class="flabel"><?php echo $form->labelEx($model,'fee'); ?></td>
		<td class="finput"><div>
		<?php echo $form->textField($model,'fee', array('class'=>'feeval','value'=>100)); ?>
		</div></td>
		<td class="fnote"> 
			<?php echo $form->error($model,'fee'); ?>
			这里可以直接输入自定义金额
		</td>
	</tr>
	<tr class="row">
		<td class="flabel">请选择</td>
		<td class="finput" colspan="2"><div>
		<input class="fee_sel" type="radio" name="radio" value="10"/>10
		<input class="fee_sel" type="radio" name="radio" value="20"/>20
		<input class="fee_sel" type="radio" name="radio" value="50"/>50
		<input class="fee_sel" type="radio" name="radio" value="100" checked/>100
		<input class="fee_sel" type="radio" name="radio" value="200"/>200
		<input class="fee_sel" type="radio" name="radio" value="500"/>500
		</div></td>
	</tr>
	<tr class="row">
		<td class="flabel">可获得元宝</td>
		<td class="finput"><div class="yuanbao" style="color:red;font-weight:bold;"><?php echo 100*$YuanBaoMultiple?></div></td>
		<td class="fnote"></td>
	</tr>
	</table>
	<?php echo $form->hiddenField($model, 'charge_type', array('value'=>"wx")); ?>

	<div class="row buttons">
		<input type="button" class="inputSubmit" onclick="showConfirm(6);" value="充值"></input>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form --></div>
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->

</div>

