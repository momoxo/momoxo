<?php

class RssAuthorHandler extends XmlTagHandler
{

    function RssGuidHandler()
    {

    }

    function getName()
    {
        return 'author';
    }

    function handleCharacterData(&$parser, &$data)
    {
        if ($parser->getParentTag() == 'item') {
            $parser->setTempArr('author', $data);
        }
    }
}
