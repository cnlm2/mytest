<?php

class ShadowFormatter extends CFormatter
{
	public function formatShadow($value)
	{
		$value = (string)$value;
		$len = mb_strlen($value);

		if ($len == 0) {
			return "";
		}
		if ($len == 1) {
			return "*";
		}
		if ($len <= 4) {
			return mb_substr($value, 0, 1).str_repeat("*",$len-1);
		}
		return mb_substr($value, 0, 1).str_repeat("*",$len-2).mb_substr($value, -1);
	}
}

