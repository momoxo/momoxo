<?php

class XoopsXmlRpcDocument
{

    var $_tags = array();

    function XoopsXmlRpcDocument()
    {

    }

    function add(&$tagobj)
    {
        $this->_tags[] =& $tagobj;
    }

    function render()
    {
    }

}
