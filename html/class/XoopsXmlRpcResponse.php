<?php

class XoopsXmlRpcResponse extends XoopsXmlRpcDocument
{
	function render()
    {
        $count = count($this->_tags);
        $payload = '';
        for ($i = 0; $i < $count; $i++) {
            if (!$this->_tags[$i]->isFault()) {
                $payload .= $this->_tags[$i]->render();
            } else {
                return '<?xml version="1.0"?><methodResponse>'.$this->_tags[$i]->render().'</methodResponse>';
            }
        }
        return '<?xml version="1.0"?><methodResponse><params><param>'.$payload.'</param></params></methodResponse>';
    }
}
