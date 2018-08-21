<?php
	Yii::import('application.vendors.*');
	require_once("szf.php");

	$szfGatewayUrl = $szf_config['szfGatewayUrl'];
    $privateKey = $szf_config['privateKey'];
	$version = $szf_config['version'];
	$merId = $szf_config['merId'];

	//组织支付请求数据
	$payMoney = (string)($model->fee * 100);//支付金额(单位：分) *
	$orderId = $model->no;//订单号（格式：yyyyMMdd-merId-SN） * 
	$pageReturnUrl = "http://www.greenyouxi.com/account/index.php/charge/szfreturn";//页面返回地址
	$serverReturnUrl = "http://www.greenyouxi.com/account/index.php/charge/szfnotify";//服务器返回地址
	$merUserName = $model->account->account;
	$merUserMail = "";//商户网站的用户的Email
	$itemName = "游戏点数充值";//产品名称
	$itemDesc = "";//产品描述
	$bankId = "";//平台银行ID
	$privateField = "";//商户私有数据
	$gatewayId = "0";//支付方式id
	if ($model->charge_type == "yd") {
		$cardTypeCombine = "0";
	} elseif ($model->charge_type == "lt") {
		$cardTypeCombine = "1";
	} elseif ($model->charge_type == "dx") {
		$cardTypeCombine = "2";
	}	
	$verifyType = "1";//数据校验方式
	$returnType = "3";//返回结果方式
	$isDebug = "0";//是否调试
	//进行MD5加密
	//md5String=md5( version+"|"  + merId+"|"  + payMoney+"|"  + orderId+"|"  + pageReturnUrl+"|"  + serverReturnUrl+"|"  + privateField+"|"  + privateKey+"|"  + verifyType+"|"  + returnType+"|"  + isDebug)
	$combineString=$version."|".$merId."|".$payMoney."|".$orderId."|".$pageReturnUrl."|".$serverReturnUrl."|".$privateField."|".$privateKey."|".$verifyType."|".$returnType."|".$isDebug;
	$md5String=md5($combineString);
?>
<script type="text/javascript"><!--
	$(document).ready(function(){
		$("#chargenow").submit();
	})
--></script>
<body>
	<form id="chargenow" method="post" name="form1" action="<?php echo $szfGatewayUrl;?>">
		<input type="hidden" name="version" value="<?php echo $version;?>">
		<input type="hidden" name="merId" value="<?php echo $merId;?>">
		<input type="hidden" name="payMoney" value="<?php echo $payMoney;?>">
		<input type="hidden" name="orderId" value="<?php echo $orderId;?>">
		<input type="hidden" name="pageReturnUrl" value="<?php echo $pageReturnUrl;?>">
		<input type="hidden" name="serverReturnUrl" value="<?php echo $serverReturnUrl;?>">
		<input type="hidden" name="merUserName" value="<?php echo $merUserName;?>">
		<input type="hidden" name="merUserMail" value="<?php echo $merUserMail;?>">
		<input type="hidden" name="itemName" value="<?php echo $itemName;?>">
		<input type="hidden" name="itemDesc" value="<?php echo $itemDesc;?>">
		<input type="hidden" name="bankId" value="<?php echo $bankId;?>">
		<input type="hidden" name="privateField" value="<?php echo $privateField;?>">
		<input type="hidden" name="gatewayId" value="<?php echo $gatewayId;?>">
		<input type="hidden" name="cardTypeCombine" value="<?php echo $cardTypeCombine;?>">
		<input type="hidden" name="verifyType" value="<?php echo $verifyType;?>">
		<input type="hidden" name="returnType" value="<?php echo $returnType;?>">
		<input type="hidden" name="isDebug" value="<?php echo $isDebug;?>">
		<input type="hidden" name="md5String" value="<?php echo $md5String;?>">
		<!--input type="submit" value="神州付支付"-->
	</form>
</body>

