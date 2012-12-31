<?php

class ThemeSetGeneratorHandler extends XmlTagHandler
{
	function ThemeSetGeneratorHandler()
	{

	}

	function getName()
	{
		return 'generator';
	}

	function handleCharacterData(&$parser, &$data)
	{
		switch ($parser->getParentTag()) {
		case 'themeset':
			$parser->setThemeSetData('generator', $data);
			break;
		default:
			break;
		}
	}
}
