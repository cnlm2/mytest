<?php
/*验证码刷新*/
class CaptchaAction extends CCaptchaAction
{
	protected function renderImageGD($code)
	{
		$image = imagecreatetruecolor($this->width,$this->height);

		$backColor = imagecolorallocate($image,
				(int)($this->backColor % 0x1000000 / 0x10000),
				(int)($this->backColor % 0x10000 / 0x100),
				$this->backColor % 0x100);
		imagefilledrectangle($image,0,0,$this->width,$this->height,$backColor);
		imagecolordeallocate($image,$backColor);

		if($this->transparent)
			imagecolortransparent($image,$backColor);

		$foreColor = imagecolorallocate($image,
				(int)($this->foreColor % 0x1000000 / 0x10000),
				(int)($this->foreColor % 0x10000 / 0x100),
				$this->foreColor % 0x100);

		if($this->fontFile === null)
			$this->fontFile = dirname(__FILE__) . '/Duality.ttf';

		$length = strlen($code);
		$box = imagettfbbox(30,0,$this->fontFile,$code);
		$w = $box[4] - $box[0] + $this->offset * ($length - 1);
		$h = $box[1] - $box[5];
		$scale = min(($this->width - $this->padding * 2) / $w,($this->height - $this->padding * 2) / $h);
		$x = 10;
		$y = round($this->height * 27 / 40);
		for($i = 0; $i < $length; ++$i)
		{
			$fontSize = (int)(rand(26,32) * $scale * 0.8);
			$angle = rand(-10,10);
			$letter = $code[$i];
			$box = imagettftext($image,$fontSize,$angle,$x,$y,$foreColor,$this->fontFile,$letter);
			$x = $box[2] + $this->offset;
		}

		imagecolordeallocate($image,$foreColor);
		/* 加干扰线和点 */
		for($i = 0; $i < 100; $i++){
			$pixelcolor = ImageColorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			imagesetpixel($image, mt_rand()%70 , mt_rand()%30 , $pixelcolor);
		}

		for ($i = 0; $i < 3; $i++) {
			$linecolor = ImageColorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
            imageline($image, mt_rand()%70 , mt_rand()%30 , mt_rand()%70 , mt_rand()%30 , $linecolor);
        }

		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Transfer-Encoding: binary');
		header("Content-type: image/png");
		imagepng($image);
		imagedestroy($image);
	}

}


