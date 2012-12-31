<?php

class ThemeSetDescriptionHandler extends XmlTagHandler
{
	function ThemeSetDescriptionHandler()
	{

	}

	function getName()
	{
		return 'description';
	}

	function handleCharacterData(&$parser, &$data)
	{
		switch ($parser->getParentTag()) {
		case 'template':
			$parser->setTempArr('description', $data);
			break;
		case 'image':
			$parser->setTempArr('description', $data);
			break;
		default:
			break;
		}
	}
}
