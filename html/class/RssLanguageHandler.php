<?php

class RssLanguageHandler extends XmlTagHandler
{

    function RssLanguageHandler()
    {

    }

    function getName()
    {
        return 'language';
    }

    function handleCharacterData(&$parser, &$data)
    {
        switch ($parser->getParentTag()) {
        case 'channel':
            $parser->setChannelData('language', $data);
            break;
        default:
            break;
        }
    }
}
