<?php

class RpcArrayHandler extends XmlTagHandler
{

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function getName()
    {
        return 'array';
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
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
        $parser->resetTempArray();
    }

    /**
    * This Method starts the parsing of the specified RDF File. The File can be a local or a remote File.
    *
    * @access
    * @author
    * @param
    * @return
    * @see
    */
    function handleEndElement(&$parser)
    {
        $parser->setTempValue($parser->getTempArray());
        $parser->releaseWorkingLevel();
    }
}
