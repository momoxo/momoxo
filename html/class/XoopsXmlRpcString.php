<?php

class XoopsXmlRpcString extends XoopsXmlRpcTag
{

    var $_value;

    function XoopsXmlRpcString($value)
    {
        $this->_value = strval($value);
    }

    function render()
    {
        return '<value><string>'.$this->encode($this->_value).'</string></value>';
    }
}
