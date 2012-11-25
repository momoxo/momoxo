<?php

/**
 *
 * @final
 */
class XCube_TextFilter
{
    var $mDummy=null;  //Dummy member for preventing object be treated as empty.

    public static function getInstance(&$instance) {
       if (empty($instance)) {
            $instance = new XCube_TextFilter();
        }
    }
    
    function toShow($str) {
        return htmlspecialchars($str, ENT_QUOTES);
    }

    function toEdit($str) {
        return htmlspecialchars($str, ENT_QUOTES);
    }

}
