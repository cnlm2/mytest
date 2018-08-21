<?php
require "statlog.lib.php";

function CallAPI($method, $url, $data = false)
{
	$curl = curl_init();

	switch ($method)
	{
	case "POST":
		curl_setopt($curl, CURLOPT_POST, 1);

		if ($data)
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		break;
	case "PUT":
		curl_setopt($curl, CURLOPT_PUT, 1);
		break;
	default:
		if ($data)
			$url = sprintf("%s?%s", $url, http_build_query($data));
	}

	// Optional Authentication:
	//	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	//	curl_setopt($curl, CURLOPT_USERPWD, "username:password");

	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	return curl_exec($curl);
}

function GetIpInfo($Ip)
{
	$db = GetPDO();

	$qst = $db->prepare("select * from ipinfo where ip=:ip");
	$qst->execute(array('ip'=>$Ip));

	$dbrt = $qst->fetch(PDO::FETCH_ASSOC);
	if ($dbrt) {
		return $dbrt;
	}

	$rt = CallAPI("GET", "http://ip.taobao.com/service/getIpInfo.php?ip={$Ip}");
	$rt = json_decode(mb_convert_encoding($rt, "GBK", "UTF-8"), true);

	$st= $db->prepare(
<<<EOD
replace into ipinfo values ( :ip,
	:country,	:country_id,
	:area,		:area_id,
	:region,	:region_id,
	:city,		:city_id,
	:county,	:county_id,
	:isp,		:isp_id)
EOD
);
	$st->execute($rt['data']);

	return $rt['data'];
}

