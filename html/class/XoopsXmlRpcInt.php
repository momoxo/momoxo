<?php

class XoopsXmlRpcInt extends XoopsXmlRpcTag
{

    var $_value;

    function XoopsXmlRpcInt($value)
    {
        $this->_value = intval($value);
    }

    function render()
    {
        return '<value><int>'.$this->_value.'</int></value>';
    }
}
