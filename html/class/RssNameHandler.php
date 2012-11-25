<?php

class RssNameHandler extends XmlTagHandler
{

    function RssNameHandler()
    {

    }

    function getName()
    {
        return 'name';
    }

    function handleCharacterData(&$parser, &$data)
    {
        switch ($parser->getParentTag()) {
        case 'textInput':
            $parser->setTempArr('name', $data);
            break;
        default:
            break;
        }
    }
}
