<?php
header("Content-type: text/html; charset=utf-8");

Yii::import('application.vendors.*');
require_once("aop.php");

//服务器异步通知页面路径
$notifyUrl = "http://www.greenyouxi.com/account/index.php/charge/notify";
//需http://格式的完整路径，不能加?id=123这类自定义参数

//页面跳转同步通知页面路径
$returnUrl = "http://www.greenyouxi.com/account/index.php/charge/return";
//需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

//商户订单号
$out_trade_no = $model->no;
//商户网站订单系统中唯一订单号，必填

//订单名称
$subject = $model->account->account;
//必填

//付款金额
$total_amount = $model->fee;
//必填

//订单描述

//$body = $_POST['WIDbody'];
$body = "";
//商品展示地址
//$show_url = $_POST['WIDshow_url'];
$show_url = "";
//需以http://开头的完整路径，例如：http://www.xxx.com/myorder.html

//防钓鱼时间戳
$anti_phishing_key = "";
//若要使用请调用类文件submit中的query_timestamp函数

//客户端的IP地址
$exter_invoke_ip = "";
//非局域网的外网IP地址，如：221.0.0.1
/************************************************************/

//构造要请求的参数数组，无需改动
$parameter = array(
		"out_trade_no"	=> $out_trade_no,
		"subject"	=> $subject,
		"total_amount"	=> $total_amount,
		"show_url"	=> $show_url,
		"body" => $body,
);


$aop = new AopClient ();
$aop->gatewayUrl = $alipay_config['gatewayUrl']; 
$aop->appId = strtolower($alipay_config['app_id']);
$aop->rsaPrivateKeyFilePath = $alipay_config['merchant_private_key'];
$aop->alipayPublicKey = $alipay_config['alipay_public_key'];
$aop->postCharset='utf-8';
$aop->format='json';

$request = new AlipayTradePrecreateRequest ();
$request->setNotifyUrl($notifyUrl);
$request->setReturnUrl($returnUrl);
$request->setBizContent(json_encode($parameter));
$result = $aop->execute ($request); 
$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
if(!empty($resultCode)&&$resultCode == 10000){
	echo $result->$responseNode->qr_code;
} else {
	//echo json_encode($result->$responseNode);
}
//建立请求
//$alipaySubmit = new AlipaySubmit($alipay_config);
//$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
//echo $html_text;

