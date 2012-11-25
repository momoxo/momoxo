<?php

class XoopsXmlRpcTag
{

    var $_fault = false;

    function XoopsXmlRpcTag()
    {

    }

    function &encode(&$text)
    {
        $text = preg_replace(array("/\&([a-z\d\#]+)\;/i", "/\&/", "/\#\|\|([a-z\d\#]+)\|\|\#/i"), array("#||\\1||#", "&amp;", "&\\1;"), str_replace(array("<", ">"), array("&lt;", "&gt;"), $text));
		return $text;
    }

    function setFault($fault = true){
        $this->_fault = (intval($fault) > 0) ? true : false;
    }

    function isFault()
    {
        return $this->_fault;
    }

    function render()
    {
    }
}
