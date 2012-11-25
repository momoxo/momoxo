<?php

class XoopsXmlRpcRequest extends XoopsXmlRpcDocument
{

	var $methodName;

	function XoopsXmlRpcRequest($methodName)
	{
		$this->methodName = trim($methodName);
	}

	function render()
    {
        $count = count($this->_tags);
        $payload = '';
        for ($i = 0; $i < $count; $i++) {
            $payload .= '<param>'.$this->_tags[$i]->render().'</param>';
        }
        return '<?xml version="1.0"?><methodCall><methodName>'.$this->methodName.'</methodName><params>'.$payload.'</params></methodCall>';
    }
}
