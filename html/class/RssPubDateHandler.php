<?php

class RssPubDateHandler extends XmlTagHandler
{

    function RssPubDateHandler()
    {

    }

    function getName()
    {
        return 'pubDate';
    }

    function handleCharacterData(&$parser, &$data)
    {
        switch ($parser->getParentTag()) {
        case 'channel':
            $parser->setChannelData('pubdate', $data);
            break;
        case 'item':
            $parser->setTempArr('pubdate', $data);
            break;
        default:
            break;
        }
    }
}
