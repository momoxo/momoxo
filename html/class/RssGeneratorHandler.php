<?php

class RssGeneratorHandler extends XmlTagHandler
{

    function RssGeneratorHandler()
    {

    }

    function getName()
    {
        return 'generator';
    }

    function handleCharacterData(&$parser, &$data)
    {
        switch ($parser->getParentTag()) {
        case 'channel':
            $parser->setChannelData('generator', $data);
            break;
        default:
            break;
        }
    }
}
