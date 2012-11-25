<?php

class RssCategoryHandler extends XmlTagHandler
{

    function RssCategoryHandler()
    {

    }

    function getName()
    {
        return 'category';
    }

    function handleCharacterData(&$parser, &$data)
    {
        switch ($parser->getParentTag()) {
        case 'channel':
            $parser->setChannelData('category', $data);
            break;
        case 'item':
            $parser->setTempArr('category', $data, ', ');
        default:
            break;
        }
    }
}
