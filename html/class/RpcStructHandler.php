<?php

class RpcStructHandler extends XmlTagHandler
{

    /**
    *
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function getName()
    {
        return 'struct';
    }

    /**
    *
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function handleBeginElement(&$parser, &$attributes)
    {
        $parser->setWorkingLevel();
        $parser->resetTempStruct();
    }

    /**
    *
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function handleEndElement(&$parser)
    {
        $parser->setTempValue($parser->getTempStruct());
        $parser->releaseWorkingLevel();
    }
}
