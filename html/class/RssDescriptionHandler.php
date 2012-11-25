<?php

class RssDescriptionHandler extends XmlTagHandler
{

    function RssDescriptionHandler()
    {

    }

    function getName()
    {
        return 'description';
    }

    function handleCharacterData(&$parser, &$data)
    {
        switch ($parser->getParentTag()) {
        case 'channel':
            $parser->setChannelData('description', $data);
            break;
        case 'image':
            $parser->setImageData('description', $data);
            break;
        case 'item':
        case 'textInput':
            $parser->setTempArr('description', $data);
            break;
        default:
            break;
        }
    }
}
