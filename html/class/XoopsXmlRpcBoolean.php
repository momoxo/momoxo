<?php

class XoopsXmlRpcBoolean extends XoopsXmlRpcTag
{

    var $_value;

    function XoopsXmlRpcBoolean($value)
    {
        $this->_value = (!empty($value) && $value != false) ? 1 : 0;
    }

    function render()
    {
        return '<value><boolean>'.$this->_value.'</boolean></value>';
    }
}
