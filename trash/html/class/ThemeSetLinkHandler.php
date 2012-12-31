<?php

class ThemeSetLinkHandler extends XmlTagHandler
{
	function ThemeSetLinkHandler()
	{

	}

	function getName()
	{
		return 'link';
	}

	function handleCharacterData(&$parser, &$data)
	{
		switch ($parser->getParentTag()) {
		case 'author':
			$parser->setTempArr('link', $data);
			break;
		default:
			break;
		}
	}
}
