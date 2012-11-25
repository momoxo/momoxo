<?php

class XoopsXmlRpcBase64 extends XoopsXmlRpcTag
{

    var $_value;

    function XoopsXmlRpcBase64($value)
    {
        $this->_value = base64_encode($value);
    }

    function render()
    {
        return '<value><base64>'.$this->_value.'</base64></value>';
    }
}
