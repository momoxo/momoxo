<?php

class ThemeSetAuthorHandler extends XmlTagHandler
{
	function ThemeSetAuthorHandler()
	{

	}

	function getName()
	{
		return 'author';
	}

	function handleBeginElement(&$parser, &$attributes)
	{
		$parser->resetTempArr();
	}

	function handleEndElement(&$parser)
	{
		$parser->setCreditsData($parser->getTempArr());
	}
}
