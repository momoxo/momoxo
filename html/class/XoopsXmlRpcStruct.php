<?php

class XoopsXmlRpcStruct extends XoopsXmlRpcTag{

    var $_tags = array();

    function XoopsXmlRpcStruct(){
    }

    function add($name, &$tagobj){
        $this->_tags[] = array('name' => $name, 'value' => $tagobj);
    }

    function render(){
        $count = count($this->_tags);
        $ret = '<value><struct>';
        for ($i = 0; $i < $count; $i++) {
            $ret .= '<member><name>'.$this->encode($this->_tags[$i]['name']).'</name>'.$this->_tags[$i]['value']->render().'</member>';
        }
        $ret .= '</struct></value>';
        return $ret;
    }
}
