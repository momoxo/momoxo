<?php

class ThemeSetDateCreatedHandler extends XmlTagHandler
{

	function ThemeSetDateCreatedHandler()
	{

	}

	function getName()
	{
		return 'dateCreated';
	}

	function handleCharacterData(&$parser, &$data)
	{
		switch ($parser->getParentTag()) {
		case 'themeset':
			$parser->setThemeSetData('date', $data);
			break;
		default:
			break;
		}
	}
}
