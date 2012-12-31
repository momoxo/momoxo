<?php

class ThemeSetImageHandler extends XmlTagHandler
{
	function ThemeSetImageHandler()
	{

	}

	function getName()
	{
		return 'image';
	}

	function handleBeginElement(&$parser, &$attributes)
	{
		$parser->resetTempArr();
		$parser->setTempArr('name', $attributes[0]);
	}

	function handleEndElement(&$parser)
	{
		$parser->setImagesData($parser->getTempArr());
	}
}
