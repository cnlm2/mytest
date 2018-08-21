<?php
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

	$version=1;
	$agent_id= $hfb_config['agent_id'];
	$key = $hfb_config['key'];
	$agent_bill_id=$model->no;
	$agent_bill_time=date('YmdHis', time());
	$chargetypes = explode(".", $model->charge_type);
	if ($chargetypes[0] == 'hfbbank') {
		$pay_type=20;
		$pay_code=$chargetypes[1];
	}
	$pay_amt=$model->fee;
	$notify_url="http://gshx2.greenyouxi.com/account/index.php/charge/hfbnotify";
	$return_url="http://gshx2.greenyouxi.com/account/index.php/charge/hfbreturn";
	$user_ip=$onlineip;
	$goods_name="Game Charge";
	$goods_num=1;
	$goods_note="";
	$remark="";
	
	//如果需要测试，请把取消关于$is_test的注释  订单会显示详细信息
	//$is_test='1’;
	//if($is_test=='1')
	//{
		//$is_test='1';
	//}
	
	
	$signStr='';
	$signStr  = $signStr . 'version=' . $version;
	$signStr  = $signStr . '&agent_id=' . $agent_id;
	$signStr  = $signStr . '&agent_bill_id=' . $agent_bill_id;
	$signStr  = $signStr . '&agent_bill_time=' . $agent_bill_time;
	$signStr  = $signStr . '&pay_type=' . $pay_type;
	$signStr  = $signStr . '&pay_amt=' . $pay_amt;
	$signStr  = $signStr .  '&notify_url=' . $notify_url;
	$signStr  = $signStr . '&return_url=' . $return_url;
	$signStr  = $signStr . '&user_ip=' . $user_ip;
	//if ($is_test == '1'){
		//$signStr  = $signStr . '&is_test=' . $is_test;
	//}
	$signStr = $signStr . '&key=' . $key;

	//获取sign密钥
	$sign='';
	$sign=md5($signStr);
?>

<form id='frmSubmit' method='post' name='frmSubmit' action='https://pay.heepay.com/Payment/Index.aspx'>
<!--form id='frmSubmit' method='post' name='frmSubmit' action='http://211.103.157.45/payheepay/Api/CardPaySubmitService.aspx'-->
<input type='hidden' name='version' value='<?php echo $version ?>' />
<input type='hidden' name='agent_id' value='<?php echo $agent_id ?>' />
<input type='hidden' name='agent_bill_id' value='<?php echo $agent_bill_id  ?>' />
<input type='hidden' name='agent_bill_time' value='<?php echo  $agent_bill_time ?>' />
<input type='hidden' name='pay_type' value='<?php echo $pay_type ?>' />
<input type='hidden' name='pay_code' value='<?php echo $pay_code  ?>' />
<input type='hidden' name='pay_amt' value='<?php echo $pay_amt  ?>' />
<input type='hidden' name='notify_url' value='<?php echo  $notify_url ?>' />
<input type='hidden' name='return_url' value='<?php echo  $return_url ?>' />
<input type='hidden' name='user_ip' value='<?php echo $user_ip  ?>' />
<input type='hidden' name='goods_name' value='<?php echo urlencode($goods_name) ?>' />
<input type='hidden' name='goods_num' value='<?php echo  urlencode($goods_num) ?>' />
<input type='hidden' name='goods_note' value='<?php echo urlencode($goods_note)  ?>' />
<input type='hidden' name='remark' value='<?php echo urlencode($remark) ?>' />
<?php
//if ($is_test == '1'){
	//echo "<input type='hidden' name='is_test' value='".$is_test."' />";
//}
?>
<input type='hidden' name='sign' value='<?php echo $sign  ?>' />
</form>
<script language='javascript'>
window.onload=function(){document.frmSubmit.submit();}
</script>


