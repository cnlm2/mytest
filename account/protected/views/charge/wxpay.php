<?php
/*
 * 参数提交页面
 */
	
	Yii::import('application.vendors.*');
	require_once("hfb.php");

	//获取ip
	$onlineip = "";
	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		$onlineip=$_SERVER['HTTP_CLIENT_IP'];
	}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$onlineip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$onlineip=$_SERVER['REMOTE_ADDR'];
	}

	$version = 1;
	$agent_id= $hfb_config['agent_id'];
	$key = $hfb_config['key'];
	$agent_bill_id=$model->no;
	$agent_bill_time = date('YmdHis', time());
    $pay_type = 30; //微信支付代码,int型
	$pay_code = ""; //char型，空字符串
	$pay_amt=$model->fee;
	$notify_url="http://gshx2.greenyouxi.com/account/index.php/charge/hfbnotify";
	$return_url="http://gshx2.greenyouxi.com/account/index.php/charge/hfbreturn";
	$user_ip=$onlineip;
	$goods_name="账号点数";
	$goods_num=1;
	$goods_note="";
	$remark="";

	/*************创建签名***************/
	$sign_str = '';
	$sign_str  = $sign_str . 'version=' . $version;
	$sign_str  = $sign_str . '&agent_id=' . $agent_id;
	$sign_str  = $sign_str . '&agent_bill_id=' . $agent_bill_id;
	$sign_str  = $sign_str . '&agent_bill_time=' . $agent_bill_time;
	$sign_str  = $sign_str . '&pay_type=' . $pay_type;
	$sign_str  = $sign_str . '&pay_amt=' . $pay_amt;
	$sign_str  = $sign_str .  '&notify_url=' . $notify_url;
	$sign_str  = $sign_str . '&return_url=' . $return_url;
	$sign_str  = $sign_str . '&user_ip=' . $user_ip;
	$sign_str = $sign_str . '&key=' . $key;
	
	$sign='';
	$sign = md5($sign_str); //签名值
?>

<form id='frmSubmit' method='post' name='frmSubmit' action='https://pay.heepay.com/Payment/Index.aspx'>
<input type='hidden' name='version' value='<?php echo $version;?>' />
<input type='hidden' name='agent_id' value='<?php echo $agent_id;?>' />
<input type='hidden' name='agent_bill_id' value='<?php echo $agent_bill_id;?>' />
<input type='hidden' name='agent_bill_time' value='<?php echo  $agent_bill_time;?>' />
<input type='hidden' name='pay_type' value='<?php echo $pay_type;?>' />
<input type='hidden' name='pay_code' value='<?php echo $pay_code;?>' />
<input type='hidden' name='pay_amt' value='<?php echo $pay_amt;?>' />
<input type='hidden' name='notify_url' value='<?php echo $notify_url;?>' />
<input type='hidden' name='return_url' value='<?php echo $return_url;?>' />
<input type='hidden' name='user_ip' value='<?php echo $user_ip;?>' />
<input type='hidden' name='goods_name' value='<?php echo urlencode($goods_name);?>' />
<input type='hidden' name='goods_num' value='<?php echo  urlencode($goods_num);?>' />
<input type='hidden' name='goods_note' value='<?php echo urlencode($goods_note);?>' />
<input type='hidden' name='remark' value='<?php echo urlencode($remark);?>' />
<input type='hidden' name='sign' value='<?php echo $sign  ?>' />
</form>
<script language='javascript'>
window.onload=function(){document.frmSubmit.submit();}
</script>
