<?php

/**
 * A hidden token field
 *
 *
 * @author      Kazumi Ono  <onokazu@xoops.org>
 * @copyright   copyright (c) 2000-2005 XOOPS.org
 */
class XoopsFormHiddenToken extends XoopsFormHidden {

    /**
     * Constructor
     *
     * @param   string  $name   "name" attribute
     */
    function XoopsFormHiddenToken($name = null, $timeout = 360){
        if (empty($name)) {
            $token =& XoopsMultiTokenHandler::quickCreate(XOOPS_TOKEN_DEFAULT);
            $name = $token->getTokenName();
        } else {
            $token =& XoopsSingleTokenHandler::quickCreate(XOOPS_TOKEN_DEFAULT);
        }
        $this->XoopsFormHidden($name, $token->getTokenValue());
    }
}
