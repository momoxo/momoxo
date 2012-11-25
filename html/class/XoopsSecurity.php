<?php

/**
 * Class for xoops.org 2.0.10 compatibility
 *
 * @deprecated
 */
class XoopsSecurity
{
    var $errors;

    function check($clearIfValid = true, $tokenValue = false) {
        return $this->validateToken($tokenValue, $clearIfValid);
    }

    function createToken($timeout = XOOPS_TOKEN_TIMEOUT)
    {
        $token =& XoopsMultiTokenHandler::quickCreate(XOOPS_TOKEN_DEFAULT, $timeout);
        return $token->getTokenValue();
    }

    function validateToken($tokenValue = false, $clearIfValid = true)
    {
        if (false !== $tokenValue) {
            $handler = new XoopsSingleTokenHandler();
            $token =& $handler->fetch(XOOPS_TOKEN_DEFAULT);
            if($token->validate($tokenValue)) {
                if ($clearIfValid) {
                    $handler->unregister($token);
                }
                return true;
            } else {
                $this->setErrors('No token found');
                return false;
            }
        }
        return XoopsMultiTokenHandler::quickValidate(XOOPS_TOKEN_DEFAULT, $clearIfValid);
    }

    function getTokenHTML() {
        $token =& XoopsMultiTokenHandler::quickCreate(XOOPS_TOKEN_DEFAULT);
        return $token->getHtml();
    }

    function setErrors($error)
    {
        $this->errors[] = trim($error);
    }

    function &getErrors($ashtml = false)
    {
        if (!$ashtml) {
            return $this->errors;
        } else {
            $ret = '';
            if (count($this->errors) > 0) {
                foreach ($this->errors as $error) {
                    $ret .= $error.'<br />';
                }
            }
            return $ret;
        }
    }
}
