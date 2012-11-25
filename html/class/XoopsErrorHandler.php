<?php

/**
 * Error handler class
 *
 * @author Michael van Dam
 */
class XoopsErrorHandler
{
    /**
     * List of errors
     *
     * @var array
     * @access private
     */
    var $_errors = array();

    /**
     * Show error messages?
     *
     * @var boolean
     * @access private
     */
    var $_showErrors = false;

    /**
     * Was there a fatal error (E_USER_ERROR)
     *
     * @var boolean
     * @access private
     */
    var $_isFatal = false;

    /**
     * Constructor
     *
     * Registers the error handler and shutdown functions.  NOTE: when
     * registering an error handler, the setting or 'error_reporting' is
     * ignored and *everything* is trapped.
     */
    function XoopsErrorHandler()
    {
        set_error_handler('XoopsErrorHandler_HandleError');
        register_shutdown_function('XoopsErrorHandler_Shutdown');
    }

    /**
     * Get the (singleton) instance of the error handler
     *
     * @access public
     */
    public static function getInstance()
    {
        static $instance = null;
        if (empty($instance)) {
            $instance = new XoopsErrorHandler;
        }
        return $instance;
    }

    /**
     * Activate the error handler
     *
     * @access public
     * @param boolean $showErrors True if debug mode is on
     * @return void
     */
    function activate($showErrors=false)
    {
        $this->_showErrors = $showErrors;
    }

    /**
     * Handle an error
     *
     * @param array $error Associative array containing error info
     * @access public
     * @return void
     */
    function handleError($error)
    {
        if ($error['errno'] == E_USER_ERROR) {
            $this->_isFatal = true;
            exit($error['errstr']);
        }
        if (($error['errno'] & error_reporting()) != $error['errno']) {
            return;
        }
        $this->_errors[] = $error;
    }

    /**
     * Render the list of errors
     *
     * NOTE: Unfortunately PHP 'fatal' and 'parse' errors are not trappable.
     * If the server has 'display_errors Off', then the result will be a
     * blank page.  It would be nice to print a message 'This page cannot
     * be displayed', but there seems to be no way to print this only when
     * exiting due to a fatal error rather than normal end of page.
     *
     * Thus, 'trigger_error' should be used to trap problems early and
     * display a meaningful message before a PHP fatal or parse error can
     * occur.
     *
     * @TODO Use CSS
     * @TODO Use language? or allow customized message?
     *
     * @access public
     * @return void
     */
    function renderErrors()
    {
		//
		// TODO We should plan new style about the following lines.
		//
        $output = '';
        if ($this->_isFatal) {
            $output .= 'This page cannot be displayed due to an internal error.<br/><br/>';
            $output .= 'If you are the administrator of this site, please visit the <a href="https://github.com/momoxo/momoxo/">XOOPS Cube Project Site</a> for assistance.<br/><br/>';
        }
        if (!$this->_showErrors || empty($this->_errors)) {
            return $output;
        }

        foreach( $this->_errors as $error )
        {
            switch ( $error['errno'] )
            {
                case E_USER_NOTICE:
                    $output .= "Notice [Xoops]: ";
                    break;
                case E_USER_WARNING:
                    $output .= "Warning [Xoops]: ";
                    break;
                case E_USER_ERROR:
                    $output .= "Error [Xoops]: ";
                    break;
                case E_NOTICE:
                    $output .= "Notice [PHP]: ";
                    break;
                case E_WARNING:
                    $output .= "Warning [PHP]: ";
                    break;
                default:
                    $output .= "Unknown Condition [" . $error['errno'] . "]: ";
            }
            $output .= sprintf( "%s in file %s line %s<br />\n", $error['errstr'], $error['errfile'], $error['errline'] );
        }
        return $output;
    }

}
