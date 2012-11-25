<?php

class RssItemHandler extends XmlTagHandler
{

    function RssItemHandler()
    {

    }

    function getName()
    {
        return 'item';
    }

    function handleBeginElement(&$parser, &$attributes)
    {
        $parser->resetTempArr();
    }

    function handleEndElement(&$parser)
    {
        $parser->setItems($parser->getTempArr());
    }
}
