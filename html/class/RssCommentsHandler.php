<?php

class RssCommentsHandler extends XmlTagHandler
{

    function RssCommentsHandler()
    {

    }

    function getName()
    {
        return 'comments';
    }

    function handleCharacterData(&$parser, &$data)
    {
        if ($parser->getParentTag() == 'item') {
            $parser->setTempArr('comments', $data);
        }
    }
}
