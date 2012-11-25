<?php

class RssWebMasterHandler extends XmlTagHandler
{

    function RssWebMasterHandler()
    {

    }

    function getName()
    {
        return 'webMaster';
    }

    function handleCharacterData(&$parser, &$data)
    {
        switch ($parser->getParentTag()) {
        case 'channel':
            $parser->setChannelData('webmaster', $data);
            break;
        default:
            break;
        }
    }
}
