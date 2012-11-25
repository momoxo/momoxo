<?php

class XoopsXmlRpcDouble extends XoopsXmlRpcTag
{

    var $_value;

    function XoopsXmlRpcDouble($value)
    {
        $this->_value = (float)$value;
    }

    function render()
    {
        return '<value><double>'.$this->_value.'</double></value>';
    }
}
