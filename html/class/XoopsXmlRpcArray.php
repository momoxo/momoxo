<?php

class XoopsXmlRpcArray extends XoopsXmlRpcTag
{

    var $_tags = array();

    function XoopsXmlRpcArray()
    {
    }

    function add(&$tagobj)
    {
        $this->_tags[] =& $tagobj;
    }

    function render()
    {
        $count = count($this->_tags);
        $ret = '<value><array><data>';
        for ($i = 0; $i < $count; $i++) {
            $ret .= $this->_tags[$i]->render();
        }
        $ret .= '</data></array></value>';
        return $ret;
    }
}
