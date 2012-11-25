<?php

class RssTtlHandler extends XmlTagHandler
{

    function RssTtlHandler()
    {

    }

    function getName()
    {
        return 'ttl';
    }

    function handleCharacterData(&$parser, &$data)
    {
        switch ($parser->getParentTag()) {
        case 'channel':
            $parser->setChannelData('ttl', $data);
            break;
        default:
            break;
        }
    }
}
