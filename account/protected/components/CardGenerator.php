<?php

global $n2c, $c2n, $a2n;

$code = "UYQR6DAEZTPF4HSGKX2I8BV59WN3LC7M";

$n2c = array();
$c2n = array();
$a2n = array();

for ($i=0; $i<32; $i++) {
	$a = ord($code[$i]);
	$c = chr($a);
	$n2c[$i] = $c;
	$c2n[$c] = $i;
	$a2n[$a] = $i;
}

function B32AtomEncode($Number, $digits)
{
	global $n2c;
	$en = array();
	for ($i = 0; $i < $digits; $i++) {
		array_push($en, $n2c[$Number & 31]);
		$Number = $Number >> 5;
	}
	return implode('',$en);
}

function B32AtomDecode($Str)
{
	global $a2n;

	$Ret = 0;
	for ($i = strlen($Str)-1; $i >= 0; $i--){
		$Ret = $Ret << 5;
		$Ret = $Ret + $a2n[ord($Str[$i])];
	}
	return $Ret;
}

function CRC16($Str) {
	$crc = 0xffff;
	for ($i = 0; $i <strlen($Str); $i++) {
		$crc = $crc ^ ord($Str[$i]);
		for ($j = 0; $j < 8; $j++) {
			$c = $crc & 1;
			$crc = $crc >> 1;
			if ($c != 0) {
				$crc = $crc  ^ 0x8408;	
			}	
		}
	}
	return $crc;
}

function sub($Str, $Start, $End)
{
	return substr($Str, $Start-1, $End-$Start+1);
}

function VerifyCard($Card)
{
	Yii::import('application.vendors.*');
	require_once("gift.php");

	if (strlen($Card) != 20) {
		return false;
	}
	$TypeCode = sub($Card, 1, 3);
	$CardInfo = $GiftCardConfig[$TypeCode];

	$SeqCode = sub($Card, 4, 8);
	$Md5Str = md5("{$SeqCode}{$CardInfo["secret"]}{$TypeCode}",true);

	$SeqCode1 = sprintf("%04X",CRC16(sub($Md5Str,1,3)));
	$SeqCode2 = sprintf("%04X",CRC16(sub($Md5Str,4,6)));
	$SeqCode3 = sprintf("%04X",CRC16(sub($Md5Str,7,9)));

	$Seq = "{$SeqCode1}{$SeqCode2}{$SeqCode3}";

	if ($Seq == sub($Card, 9, 20) ) {
		return $CardInfo;
	} else {
		return false;
	}
}

function GenCode($Prefix, $Seq)
{
	Yii::import('application.vendors.*');
	require_once("gift.php");

	$CardInfo = $GiftCardConfig[$Prefix];

	$TypeCode = $Prefix;
	$SeqCode = B32AtomEncode($Seq,5);

	$Md5Str = md5("{$SeqCode}{$CardInfo["secret"]}${TypeCode}", true);

	$Seg1Code = sprintf("%04X",CRC16(sub($Md5Str,1,3)));
	$Seg2Code = sprintf("%04X",CRC16(sub($Md5Str,4,6)));
	$Seg3Code = sprintf("%04X",CRC16(sub($Md5Str,7,9)));

	return "{$TypeCode}{$SeqCode}{$Seg1Code}{$Seg2Code}{$Seg3Code}";
}

function GenCodeEx($Prefix, $Seq)
{
	Yii::import('application.vendors.*');
	require("gift.php");

	$CardInfo = $GiftCardConfig[$Prefix];

	$TypeCode = $Prefix;
	$SeqCode = B32AtomEncode($Seq,5);

	$Md5Str = md5("{$SeqCode}{$CardInfo["secret"]}${TypeCode}", true);

	$SeqCode1 = sprintf("%04X",CRC16(sub($Md5Str,1,3)));
	$SeqCode2 = sprintf("%04X",CRC16(sub($Md5Str,4,6)));
	$SeqCode3 = sprintf("%04X",CRC16(sub($Md5Str,7,9)));

	return "{$TypeCode}{$SeqCode}{$Seg1Code}{$Seg2Code}{$Seg3Code}";
}

