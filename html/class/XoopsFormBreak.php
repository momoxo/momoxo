<?php

class XoopsFormBreak extends XoopsFormElement {
    function XoopsFormBreak($extra = '', $class= '') {
        $this->setExtra($extra);
        $this->setClass($class);
    }
    
    function isBreak() {
        return true;
    }
}
