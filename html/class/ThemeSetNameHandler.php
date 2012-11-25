<?php

class ThemeSetNameHandler extends XmlTagHandler
{
	function ThemeSetNameHandler()
	{

	}

	function getName()
	{
		return 'name';
	}

	function handleCharacterData(&$parser, &$data)
	{
		switch ($parser->getParentTag()) {
		case 'themeset':
			$parser->setThemeSetData('name', $data);
			break;
		case 'author':
			$parser->setTempArr('name', $data);
			break;
		default:
			break;
		}
	}
}
