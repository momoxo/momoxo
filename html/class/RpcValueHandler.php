<?php

class RpcValueHandler extends XmlTagHandler
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
        return 'value';
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
        switch ($parser->getParentTag()) {
        case 'member':
            $parser->setTempValue($data);
            break;
        case 'data':
        case 'array':
            $parser->setTempValue($data);
            break;
        default:
            break;
        }
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
        //$parser->resetTempValue();
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
        switch ($parser->getCurrentTag()) {
        case 'member':
            $parser->setTempMember($parser->getTempName(), $parser->getTempValue());
            break;
        case 'array':
        case 'data':
            $parser->setTempArray($parser->getTempValue());
            break;
        default:
            $parser->setParam($parser->getTempValue());
            break;
        }
        $parser->resetTempValue();
    }
}
