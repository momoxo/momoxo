<?php

class RssLinkHandler extends XmlTagHandler
{

    function RssLinkHandler()
    {

    }

    function getName()
    {
        return 'link';
    }

    function handleCharacterData(&$parser, &$data)
    {
        switch ($parser->getParentTag()) {
        case 'channel':
            $parser->setChannelData('link', $data);
            break;
        case 'image':
            $parser->setImageData('link', $data);
            break;
        case 'item':
        case 'textInput':
            $parser->setTempArr('link', $data);
            break;
        default:
            break;
        }
    }
}
