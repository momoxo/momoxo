<?php

class ThemeSetEmailHandler extends XmlTagHandler
{
	function ThemeSetEmailHandler()
	{

	}

	function getName()
	{
		return 'email';
	}

	function handleCharacterData(&$parser, &$data)
	{
		switch ($parser->getParentTag()) {
		case 'author':
			$parser->setTempArr('email', $data);
			break;
		default:
			break;
		}
	}
}
