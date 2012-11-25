<?php

class RssWidthHandler extends XmlTagHandler
{

    function RssWidthHandler()
    {

    }

    function getName()
    {
        return 'width';
    }

    function handleCharacterData(&$parser, &$data)
    {
        if ($parser->getParentTag() == 'image') {
            $parser->setImageData('width', $data);
        }
    }
}
