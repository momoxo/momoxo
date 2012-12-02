<?php

/**
 * @public
 * @brief Utility class which collects utility functions for delegates.
 * 
 *    XCube_DelegateUtils::call("Delegate Name"[, fuction args...]); \n
 *    XCube_DelegateUtils::raiseEvent("Event Name"[, fuction params...]); \n
 *    $string = XCube_DelegateUtils::applyStringFilter("Filter Name", $string, [, option params...]); \n
 */
use XCore\Kernel\Root;
use XCore\Kernel\DelegateManager;
use XCore\Kernel\Ref;

class XCube_DelegateUtils
{
	/**
	 * @private
	 * @brief Private Construct. In other words, it's possible to create an instance of this class.
	 */
	function __construct()
	{
	}

    static function call()
    {
        $args = func_get_args();
        $num = func_num_args();
        if ($num == 1) $delegateName = $args[0];
		elseif ($num) $delegateName = array_shift($args);
		else return false;
		$m = Root::getSingleton()->mDelegateManager;
        if ($m) {
            $delegates = $m->getDelegates();
            if (isset($delegates[$delegateName])) {
				$delegates = &$delegates[$delegateName];
				list($key) = array_keys($delegates);
                $delegate =& $delegates[$key];
            } else {
                $delegate = new XCube_Delegate;
                $m->register($delegateName, $delegate);
            }
        }
        return call_user_func_array(array(&$delegate,'call'),$args);
    }

    /**
     * @deprecated Use call()
     * @public
     * @brief [Static] Utility method for calling event-delegates.
     * 
     * This method is a shortcut for calling delegates without actual delegate objects.
     * If there is not the delegate specified by the 1st parameter, the delegate will
     * be made right now. Therefore, this method is helpful for events.
     * 
     * @note
     *     \code
     *       XCube_DelegateUtils::raiseEvent("Module.A.Exception.Null");
     *     \endcode
     * 
     *     The uppering code equals the following code;
     * 
     *     \code
     *       {
     *	       $local =new XCube_Delegate();
     *	       $local->register("Module.A.Exception.Null");
     *	       $local->call();
     *	     }
     *     \endcode
     *
     * @attention
     *     Only event-owners should use this method. Outside program never calls other's
     *     events. This is a kind of XCube_Delegate rules. There is the following code;
     * 
     *     \code
     *        ClassA::check()
     *        {
     *          if ($this->mThing == null)
     *             XCube_DelegateUtils::raiseEvent("Module.A.Exception.Null");
     *	      }
     *     \endcode
     *
     *      In this case, other class never calls the event.
     *
     *      \code
     *        //
     *        // NEVER writes the following code;
     *        //
     *        $obj = new ClassA();
     *        if ($obj->mThing == null)
     *             XCube_DelegateUtils::raiseEvent("Module.A.Exception.Null");
     *     \endcode
     * 
     *     Other classes may call only ClassA::check();
     *
     * @param 1st  Delaget Name
     * @param 2nd and more : Delegate function parameters
     * @return bool
     */
    function raiseEvent()
    {
        if (func_num_args()) {
			$args = func_get_args();
            return call_user_func_array(array('XCube_DelegateUtils','call'), $args);
        }
    }

    /**
     * @public
     * @internal
     * @brief [Static] Calls a delegate string filter function. This method is multi-parameters.
     * 
     * This is a special shortcut for processing string filter.
     *
     * @param 1st string - Delaget Name
     * @param 2nd string
     * @param 3rd and more - Optional function paramaters
     * @return string
     */
    function applyStringFilter()
    {
        $args = func_get_args();
        $num = func_num_args();
        if ($num > 1) {
            $delegateName = $args[0];
            $string = $args[1];
            if (!empty($string) && is_string($string)) {
                return "";
            }
            $args[1] = new Ref($string);
            call_user_func_array(array('XCube_DelegateUtils','call'),$args);
            return $string;
        } else {
            return "";
        }
    }
    
    /**
     * @public
     * @internal
     * @brief [Static][Secret Agreement] Comparing two callback (PHP4 cannot compare Object exactly)
     * @param $callback1  : callback
     * @param $callback2  : callback
     * @return bool
     * 
     * @attention
     *     Only XCube_Delegate, DelegateManager and sub-classes of them should use this method.
     */
    public static function _compareCallback($callback1, $callback2)
    {
        if (!is_array($callback1) && !is_array($callback2) && ($callback1 === $callback2)) {
            return true;
        } elseif (is_array($callback1) && is_array($callback2) && (gettype($callback1[0]) === gettype($callback2[0])) 
                                                               && ($callback1[1] === $callback2[1])) {
            if (!is_object($callback1[0]) && ($callback1[0] === $callback2[0])) {
                return true;
            } elseif (is_object($callback1[0]) && (get_class($callback1[0]) === get_class($callback2[0]))) {
                return true;
            }
        }
        return false;
    }
}
