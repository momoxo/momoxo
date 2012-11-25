<?php

class RssUrlHandler extends XmlTagHandler
{

    function RssUrlHandler()
    {

    }

    function getName()
    {
        return 'url';
    }

    function handleCharacterData(&$parser, &$data)
    {
        if ($parser->getParentTag() == 'image') {
            $parser->setImageData('url', $data);
        }
    }
}
