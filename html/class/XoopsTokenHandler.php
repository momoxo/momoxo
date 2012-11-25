<?php

/**
 * This class express ticket agent and ticket collector. this publishes
 * token, keeps a token to server to check it later(next request).
 *
 * You can create various agents by extending the derivative class. see
 * default(sample) classes.
 */
class XoopsTokenHandler
{
    /**
     * @access private
     */
    var $_prefix ="";


    /**
     * Create XoopsToken instance, regist(keep to server), and returns it.
     *
     * @access public
     * @param   $name   this token's name string.
     * @param   $timeout    effective time(if $timeout equal 0, this token will become unlimited)
     */
    function &create($name,$timeout = XOOPS_TOKEN_TIMEOUT)
    {
        $token =new XoopsToken($name,$timeout);
        $this->register($token);
        return $token;
    }

    /**
     * Fetches from server side, and returns it.
     *
     * @access public
     * @param   $name   token's name string.
     * @return XoopsToken
     */
    function &fetch($name)
    {
        $ret = null;
        if(isset($_SESSION[XOOPS_TOKEN_SESSION_STRING][$this->_prefix.$name])) {
            $ret =& $_SESSION[XOOPS_TOKEN_SESSION_STRING][$this->_prefix.$name];
        }
        return $ret;
    }

    /**
     * Register token to session.
     */
    function register(&$token)
    {
        $_SESSION[XOOPS_TOKEN_SESSION_STRING][$this->_prefix.$token->_name_] = $token;
    }

    /**
     * Unregister token to session.
     */
    function unregister(&$token)
    {
        unset($_SESSION[XOOPS_TOKEN_SESSION_STRING][$this->_prefix.$token->_name_]);
    }

    /**
     * If a token of the name that equal $name is registered on session,
     * this method will return true.
     *
     * @access  public
     * @param   $name   token's name string.
     * @return  bool
     */
    function isRegistered($name)
    {
        return isset($_SESSION[XOOPS_TOKEN_SESSION_STRING][$this->_prefix.$name]);
    }

    /**
     * This method takes out token's string from Request, and validate
     * token with it. if it passed validation, this method will return true.
     *
     * @access  public
     * @param   $token  XoopsToken
     * @param   $clearIfValid   If token passed validation, $token will be unregistered.
     * @return  bool
     */
    function validate(&$token,$clearIfValid)
    {
        $req_token = isset($_REQUEST[ $token->getTokenName() ]) ?
                trim($_REQUEST[ $token->getTokenName() ]) : null;

        if($req_token) {
            if($token->validate($req_token)) {
                if($clearIfValid)
                    $this->unregister($token);
                return true;
            }
        }
        return false;
    }
}
