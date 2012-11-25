<?php

class ThemeSetTagHandler extends XmlTagHandler
{
	function ThemeSetTagHandler()
	{

	}

	function getName()
	{
		return 'tag';
	}

	function handleCharacterData(&$parser, &$data)
	{
		switch ($parser->getParentTag()) {
		case 'image':
			$parser->setTempArr('tag', $data);
			break;
		default:
			break;
		}
	}
}
