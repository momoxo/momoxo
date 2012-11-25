<?php

class RssManagingEditorHandler extends XmlTagHandler
{

    function RssManagingEditorHandler()
    {

    }

    function getName()
    {
        return 'managingEditor';
    }

    function handleCharacterData(&$parser, &$data)
    {
        switch ($parser->getParentTag()) {
        case 'channel':
            $parser->setChannelData('editor', $data);
            break;
        default:
            break;
        }
    }
}
