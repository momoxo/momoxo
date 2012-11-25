<?php

class RpcMemberHandler extends XmlTagHandler
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
        return 'member';
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
        $parser->resetTempMember();
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
        $member =& $parser->getTempMember();
        $parser->releaseWorkingLevel();
        $parser->setTempStruct($member);
    }
}
