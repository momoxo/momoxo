<?php

class RssCopyrightHandler extends XmlTagHandler
{

    function RssCopyrightHandler()
    {

    }

    function getName()
    {
        return 'copyright';
    }

    function handleCharacterData(&$parser, &$data)
    {
        switch ($parser->getParentTag()) {
        case 'channel':
            $parser->setChannelData('copyright', $data);
            break;
        default:
            break;
        }
    }
}
