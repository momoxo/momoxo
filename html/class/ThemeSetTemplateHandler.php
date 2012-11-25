<?php

class ThemeSetTemplateHandler extends XmlTagHandler
{
	function ThemeSetTemplateHandler()
	{

	}

	function getName()
	{
		return 'template';
	}

	function handleBeginElement(&$parser, &$attributes)
	{
		$parser->resetTempArr();
		$parser->setTempArr('name', $attributes['name']);
	}

	function handleEndElement(&$parser)
	{
		$parser->setTemplatesData($parser->getTempArr());
	}
}
