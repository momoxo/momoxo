<?php

class RssLastBuildDateHandler extends XmlTagHandler
{

    function RssLastBuildDateHandler()
    {

    }

    function getName()
    {
        return 'lastBuildDate';
    }

    function handleCharacterData(&$parser, &$data)
    {
        switch ($parser->getParentTag()) {
        case 'channel':
            $parser->setChannelData('lastbuilddate', $data);
            break;
        default:
            break;
        }
    }
}
