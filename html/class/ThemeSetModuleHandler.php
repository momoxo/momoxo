<?php

class ThemeSetModuleHandler extends XmlTagHandler
{
	function ThemeSetModuleHandler()
	{

	}

	function getName()
	{
		return 'module';
	}

	function handleCharacterData(&$parser, &$data)
	{
		switch ($parser->getParentTag()) {
		case 'template':
		case 'image':
			$parser->setTempArr('module', $data);
			break;
		default:
			break;
		}
	}
}
