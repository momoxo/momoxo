<?php

class ThemeSetFileTypeHandler extends XmlTagHandler
{
	function ThemeSetFileTypeHandler()
	{

	}

	function getName()
	{
		return 'fileType';
	}

	function handleCharacterData(&$parser, &$data)
	{
		switch ($parser->getParentTag()) {
		case 'template':
			$parser->setTempArr('type', $data);
			break;
		default:
			break;
		}
	}
}
