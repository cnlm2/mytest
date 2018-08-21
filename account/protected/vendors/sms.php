<?php

include dirname(__FILE__).'/taobaosdk/TopSdk.php';
include dirname(__FILE__).'/taobaosdk/top/TopClient.php';
include dirname(__FILE__).'/taobaosdk/top/request/AlibabaAliqinFcSmsNumSendRequest.php';
include dirname(__FILE__).'/taobaosdk/top/ResultSet.php';
include dirname(__FILE__).'/taobaosdk/top/RequestCheckUtil.php';
include dirname(__FILE__).'/taobaosdk/top/TopLogger.php';

function SendMsg($phone, $msgid, $msgparam) {
	date_default_timezone_set('Asia/Shanghai'); 
    $c = new TopClient;
    $c->appkey = '23707927';
    $c->secretKey = 'ecb5ecd65462ff08d9d143aa11c5c04d';
	$req = new AlibabaAliqinFcSmsNumSendRequest;
	$req->setSmsType("normal");
	$req->setSmsFreeSignName("盖世豪侠");
	$req->setSmsParam($msgparam);
	$req->setRecNum($phone);
	$req->setSmsTemplateCode($msgid);
	$resp = $c->execute($req);
	return $resp->result->success == true;
}

function SendVerify($phone){
	$cache = Yii::app()->cache->get($phone);
	if (!$cache) {
		$cache = array('phone'=>$phone,'month_send_times'=>0,'today_send_times'=>0);
	}
	$randStr = str_shuffle('1234567890');
	$randcode = substr($randStr,0,6);
	$msgparam = array("param1"=>$randcode,"param2"=>"10");
	if (!SendMsg($phone ,"SMS_56610512", json_encode($msgparam))) {
		return;
	}
	$cache['time'] = time();
	$cache['randcode'] = $randcode;
	$cache['today_send_times'] += 1;
	$cache['month_send_times'] += 1;
	Yii::app()->cache->set($phone,$cache);
	return true;
}

function Verify($phone,$code) {
	$cache = Yii::app()->cache->get($phone);
	return $cache && $cache['randcode'] === $code;
}
/*
function curl_get($url='', $options=array()){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    if (!empty($options)){
        curl_setopt_array($ch, $options);
    }
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function curl_post($url='', $postdata='', $options=array()){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    if (!empty($options)){
        curl_setopt_array($ch, $options);
    }
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function get_token($app_id,$app_secret,$access_token)
{
	$timestamp = date('Y-m-d H:i:s');
	$url = "http://api.189.cn/v2/dm/randcode/token?";
    $param['app_id']= "app_id=".$app_id;
    $param['access_token'] = "access_token=".$access_token;
    $param['timestamp'] = "timestamp=".$timestamp;
    ksort($param);
    $plaintext = implode("&",$param);
    $param['sign'] = "sign=".rawurlencode(base64_encode(hash_hmac("sha1", $plaintext, $app_secret, $raw_output=True)));
    ksort($param);
    $url .= implode("&",$param);
    $result = curl_get($url);
    $resultArray = json_decode($result,true);
    $token = $resultArray['token'];
	return $token;
}

function send_verify($app_id,$app_secret,$access_token,$token,$phone,$randcode)
{
	$url = "http://api.189.cn/v2/dm/randcode/sendSms";
	$timestamp = date('Y-m-d H:i:s');
    $param['app_id']= "app_id=".$app_id;
    $param['access_token'] = "access_token=".$access_token;
    $param['timestamp'] = "timestamp=".$timestamp;
    $param['token'] = "token=".$token;
    $param['phone'] = "phone=".$phone;
    $param['randcode'] = "randcode=".$randcode;
    $param['exp_time'] = "exp_time=".$exp_time;
    ksort($param);
    $plaintext = implode("&",$param);
    $param['sign'] = "sign=".rawurlencode(base64_encode(hash_hmac("sha1", $plaintext, $app_secret, $raw_output=True)));
    ksort($param);
    $str = implode("&",$param);
    $result = curl_post($url,$str);
    $resultArray = json_decode($result,true);
	if (array_key_exists('identifier', $resultArray)) {
		return true;
	}
	return false;
}

function send_msg($app_id,$app_secret,$access_token,$acceptor_tel,$template_id,$template_param)
{
	$url = "http://api.189.cn/v2/emp/templateSms/sendSms";
	$timestamp = date('Y-m-d H:i:s');

    $param['app_id']= "app_id=".$app_id;
    $param['access_token'] = "access_token=".$access_token;
    $param['timestamp'] = "timestamp=".$timestamp;
    $param['acceptor_tel'] = "acceptor_tel=".$acceptor_tel;
    $param['template_id'] = "template_id=".$template_id;
    $param['template_param'] = "template_param=".$template_param;
	 ksort($param);
    $plaintext = implode("&",$param);
    $param['sign'] = "sign=".rawurlencode(base64_encode(hash_hmac("sha1", $plaintext, $app_secret, $raw_output=True)));
    ksort($param);
    $str = implode("&",$param);
    $result = curl_post($url,$str);
    $resultArray = json_decode($result,true);
	return ($resultArray['res_message'] == "Success");
}
 */
?>

