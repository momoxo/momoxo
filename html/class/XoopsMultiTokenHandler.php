<?php

/**
 * This class publish a token of the different same name of a serial number
 * for the tab browser.
 */
class XoopsMultiTokenHandler extends XoopsTokenHandler
{
    function &create($name,$timeout=XOOPS_TOKEN_TIMEOUT)
    {
        $token =new XoopsToken($name,$timeout);
        $token->setSerialNumber($this->getUniqueSerial($name));
        $this->register($token);
        return $token;
    }

    function &fetch($name,$serial_number)
    {
        $ret = null;
        if(isset($_SESSION[XOOPS_TOKEN_MULTI_SESSION_STRING][$this->_prefix.$name][$serial_number])) {
            $ret =& $_SESSION[XOOPS_TOKEN_MULTI_SESSION_STRING][$this->_prefix.$name][$serial_number];
        }
        return $ret;
    }

    function register(&$token)
    {
        $_SESSION[XOOPS_TOKEN_MULTI_SESSION_STRING][$this->_prefix.$token->_name_][$token->getSerialNumber()] = $token;
    }

    function unregister(&$token)
    {
        unset($_SESSION[XOOPS_TOKEN_MULTI_SESSION_STRING][$this->_prefix.$token->_name_][$token->getSerialNumber()]);
    }

    function isRegistered($name,$serial_number)
    {
        return isset($_SESSION[XOOPS_TOKEN_MULTI_SESSION_STRING][$this->_prefix.$name][$serial_number]);
    }

    function autoValidate($name,$clearIfValid=true)
    {
        $serial_number = $this->getRequestNumber($name);
        if($serial_number!==null) {
            if($token =& $this->fetch($name,$serial_number)) {
                return $this->validate($token,$clearIfValid);
            }
        }
        return false;
    }

    /**
     * static method.
     * This method was created for quick protection of default modules.
     * this method will be deleted in the near future.
     * @deprecated
     * @return bool
    */
    function &quickCreate($name,$timeout = XOOPS_TOKEN_TIMEOUT)
    {
        $handler =new XoopsMultiTokenHandler();
        $ret =& $handler->create($name,$timeout);
        return $ret;
    }

    /**
     * static method.
     * This method was created for quick protection of default modules.
     * this method will be deleted in the near future.
     * @deprecated
     * @return bool
    */
    function quickValidate($name,$clearIfValid=true)
    {
        $handler = new XoopsMultiTokenHandler();
        return $handler->autoValidate($name,$clearIfValid);
    }

    /**
     * @param   $name   string
     * @return  int
     */
    function getRequestNumber($name)
    {
        $str = XOOPS_TOKEN_PREFIX.$name."_";
        foreach($_REQUEST as $key=>$val) {
            if(preg_match("/".$str."(\d+)/",$key,$match))
                return intval($match[1]);
        }

        return null;
    }

    function getUniqueSerial($name)
    {
        if(isset($_SESSION[XOOPS_TOKEN_MULTI_SESSION_STRING][$name])) {
            if(is_array($_SESSION[XOOPS_TOKEN_MULTI_SESSION_STRING][$name])) {
                for($i=0;isset($_SESSION[XOOPS_TOKEN_MULTI_SESSION_STRING][$name][$i]);$i++);
                return $i;
            }
        }

        return 0;
    }
}
