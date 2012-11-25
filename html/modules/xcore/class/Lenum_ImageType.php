<?php

class Lenum_ImageType
{
	const GIF = 1;
	const JPG = 2;
	const PNG = 3;

	public static function getName(/*** Enum ***/ $ext)
	{
		switch($ext){
		case self::GIF:
			return 'gif';
			break;
		case self::JPG:
			return 'jpg';
			break;
		case self::PNG:
			return 'png';
			break;
		}
	}
}
