<?php

class RpcDoubleHandler extends XmlTagHandler
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
        return 'double';
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
    function handleCharacterData(&$parser, &$data)
    {
        $data = (float)$data;
        $parser->setTempValue($data);
    }
}
