<?php

class XoopsXmlRpcDatetime extends XoopsXmlRpcTag
{

    var $_value;

    function XoopsXmlRpcDatetime($value)
    {
        if (!is_numeric($value)) {
            $this->_value = strtotime($value);
        } else {
            $this->_value = intval($value);
        }
    }

    function render()
    {
        return '<value><dateTime.iso8601>'.gmstrftime("%Y%m%dT%H:%M:%S", $this->_value).'</dateTime.iso8601></value>';
    }
}
