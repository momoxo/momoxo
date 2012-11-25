<?php

/**
 * This class express token. this has name, token's string for inquiry,
 * lifetime, serial number. this does not have direct validation method,
 * therefore this does not depend on $_Session and $_Request.
 *
 * You can refer to a handler class for this token. this token class
 * means ticket, and handler class means ticket agent. there is a strict
 * ticket agent type(XoopsSingleTokenHandler), and flexible ticket agent
 * for the tab browser(XoopsMultiTokenHandler).
 */
class XoopsToken
{
    /**
     * token's name. this is used for identification.
     * @access protected
     */
    var $_name_;

    /**
     * token's string for inquiry. this should be a random code for security.
     * @access private
     */
    var $_token_;

    /**
     * the unixtime when this token is effective.
     *
     * @access protected
     */
    var $_lifetime_;

    /**
     * unlimited flag. if this is true, this token is not limited in lifetime.
     */
    var $_unlimited_;

    /**
     * serial number. this used for identification of tokens of same name tokens.
     *
     * @access private
     */
    var $_number_=0;

    /**
     * @param   $name   this token's name string.
     * @param   $timeout    effective time(if $timeout equal 0, this token will become unlimited)
     */
    function XoopsToken($name, $timeout = XOOPS_TOKEN_TIMEOUT)
    {
        $this->_name_ = $name;

        if($timeout) {
            $this->_lifetime_ = time() + $timeout;
            $this->_unlimited_ = false;
        }
        else {
            $this->_lifetime_ = 0;
            $this->_unlimited_ = true;
        }

        $this->_token_ = $this->_generateToken();
    }


    /**
     * Returns random string for token's string.
     *
     * @access protected
     * @return string
     */
    function _generateToken()
    {
        srand(microtime()*100000);
        return md5(XOOPS_SALT.$this->_name_.uniqid(rand(),true));
    }

    /**
     * Returns this token's name.
     *
     * @access public
     * @return string
     */
    function getTokenName()
    {
        return XOOPS_TOKEN_PREFIX.$this->_name_."_".$this->_number_;
    }

    /**
     * Returns this token's string.
     *
     * @access public
     * @return  string
     */
    function getTokenValue()
    {
        return $this->_token_;
    }

    /**
     * Set this token's serial number.
     *
     * @access public
     * @param   $serial_number  serial number
     */
    function setSerialNumber($serial_number)
    {
        $this->_number_ = $serial_number;
    }

    /**
     * Returns this token's serial number.
     *
     * @access public
     * @return  int
     */
    function getSerialNumber()
    {
        return $this->_number_;
    }

    /**
     * Returns hidden tag string that includes this token. you can use it
     * for <form> tag's member.
     *
     * @access public
     * @return  string
     */
    function getHtml()
    {
        return @sprintf('<input type="hidden" name="%s" value="%s" />',$this->getTokenName(),$this->getTokenValue());
    }

    /**
     * Returns url string that includes this token. you can use it for
     * hyper link.
     *
     * @return  string
     */
    function getUrl()
    {
        return $this->getTokenName()."=".$this->getTokenValue();
    }

    /**
     * If $token equals this token's string, true is returened.
     *
     * @return  bool
    */
    function validate($token=null)
    {
        return ($this->_token_==$token && ( $this->_unlimited_ || time()<=$this->_lifetime_));
    }
}
