<?php

class XoopsSingleTokenHandler extends XoopsTokenHandler
{
    function autoValidate($name,$clearIfValid=true)
    {
        if($token =& $this->fetch($name)) {
            return $this->validate($token,$clearIfValid);
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
        $handler =new XoopsSingleTokenHandler();
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
        $handler = new XoopsSingleTokenHandler();
        return $handler->autoValidate($name,$clearIfValid);
    }
}
