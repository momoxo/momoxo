<?php

class RssHeightHandler extends XmlTagHandler
{

    function RssHeightHandler()
    {
    }

    function getName()
    {
        return 'height';
    }

    function handleCharacterData(&$parser, &$data)
    {
        if ($parser->getParentTag() == 'image') {
            $parser->setImageData('height', $data);
        }
    }
}
