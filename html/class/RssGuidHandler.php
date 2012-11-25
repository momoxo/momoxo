<?php

class RssGuidHandler extends XmlTagHandler
{

    function RssGuidHandler()
    {

    }

    function getName()
    {
        return 'guid';
    }

    function handleCharacterData(&$parser, &$data)
    {
        if ($parser->getParentTag() == 'item') {
            $parser->setTempArr('guid', $data);
        }
    }
}
