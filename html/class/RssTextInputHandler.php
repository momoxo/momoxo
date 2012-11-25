<?php

class RssTextInputHandler extends XmlTagHandler
{

    function RssWebMasterHandler()
    {

    }

    function getName()
    {
        return 'textInput';
    }

    function handleBeginElement(&$parser, &$attributes)
    {
        $parser->resetTempArr();
    }

    function handleEndElement(&$parser)
    {
        $parser->setChannelData('textinput', $parser->getTempArr());
    }
}
