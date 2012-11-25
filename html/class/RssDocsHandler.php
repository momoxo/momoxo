<?php

class RssDocsHandler extends XmlTagHandler
{

    function RssDocsHandler()
    {

    }

    function getName()
    {
        return 'docs';
    }

    function handleCharacterData(&$parser, &$data)
    {
        switch ($parser->getParentTag()) {
        case 'channel':
            $parser->setChannelData('docs', $data);
            break;
        default:
            break;
        }
    }
}
