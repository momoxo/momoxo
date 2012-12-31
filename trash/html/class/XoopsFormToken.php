<?php

class XoopsFormToken extends XoopsFormHidden {
    /**
     * Constructor
     *
     * @param object    $token  XoopsToken instance
    */
    function XoopsFormToken($token)
    {
        if(is_object($token)) {
            parent::XoopsFormHidden($token->getTokenName(), $token->getTokenValue());
        }
        else {
            parent::XoopsFormHidden('','');
        }
    }
}
