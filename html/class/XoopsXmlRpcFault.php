<?php

class XoopsXmlRpcFault extends XoopsXmlRpcTag
{

    var $_code;
    var $_extra;

    function XoopsXmlRpcFault($code, $extra = null)
    {
        $this->setFault(true);
        $this->_code = intval($code);
        $this->_extra = isset($extra) ? trim($extra) : '';
    }

    function render()
    {
        switch ($this->_code) {
        case 101:
            $string = 'Invalid server URI';
            break;
        case 102:
            $string = 'Parser parse error';
            break;
        case 103:
            $string = 'Module not found';
            break;
        case 104:
            $string = 'User authentication failed';
            break;
        case 105:
            $string = 'Module API not found';
            break;
        case 106:
            $string = 'Method response error';
            break;
        case 107:
            $string = 'Method not supported';
            break;
        case 108:
            $string = 'Invalid parameter';
            break;
        case 109:
            $string = 'Missing parameters';
            break;
        case 110:
            $string = 'Selected blog application does not exist';
            break;
        case 111:
            $string = 'Method permission denied';
            break;
        default:
            $string = 'Method response error';
            break;
        }
        $string .= "\n".$this->_extra;
        return '<fault><value><struct><member><name>faultCode</name><value>'.$this->_code.'</value></member><member><name>faultString</name><value>'.$this->encode($string).'</value></member></struct></value></fault>';
    }
}
