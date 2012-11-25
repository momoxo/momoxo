<?php

class RssTitleHandler extends XmlTagHandler
{

    function RssTitleHandler()
    {

    }

    function getName()
    {
        return 'title';
    }

    function handleCharacterData(&$parser, &$data)
    {
        switch ($parser->getParentTag()) {
        case 'channel':
            $parser->setChannelData('title', $data);
            break;
        case 'image':
            $parser->setImageData('title', $data);
            break;
        case 'item':
        case 'textInput':
            $parser->setTempArr('title', $data);
            break;
        default:
            break;
        }
    }
}
