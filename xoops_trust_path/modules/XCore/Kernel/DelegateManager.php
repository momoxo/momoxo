<?php

namespace XCore\Kernel;

use XCube_Delegate;
use XCube_DelegateUtils;

/**
 * @public
 * @brief Manages for delegates.
 *
 * This is the agent of un-registered delegate objects. Usually, connected
 * functions can't be added to un-registered delegates. When destination
 * delegates are un-registered yet, this manager is keeping those functions
 * and parameters until the destination delegate will be registered.
 *
 * In other words, this class realizes lazy delegate registering.
 */
class DelegateManager
{
	/**
	 * @protected
	 * @brief Complex Array
	 */
	var $_mCallbacks = array();

	/**
	 * @protected
	 * @brief Complex Array
	 */
	var $_mCallbackParameters = array();

	/**
	 * @protected
	 * @var array
	 */
	var $_mDelegates = array();

	/**
	 * @public
	 * @brief Constructor.
	 */
	function __construct()
	{
	}

	/**
	 * @public
	 * @brief Adds $delegate as Delegate to the list of this manager.
	 * @param $name string - Registration name.
	 * @param $delegate XCube_Delegate - Delegate object which will be registered.
	 * @return bool
	 *
	 * If some functions that want to connect to $delegate, have been entrusted yet,
	 * this object calls add() of $delegate with their parameters.
	 *
	 * Usually this member function isn't used as Cube's API by developers. In many
	 * cases, XCube_Delegate::register() calls this.
	 */
	function register($name, &$delegate)
	{
		$mDelegate =& $this->_mDelegates[$name];
		if (isset($mDelegate[$id=$delegate->getID()])) {
			return false;
		}
		else {
			$mDelegate[$id] =& $delegate;

			$mcb = &$this->_mCallbacks[$name];
			if (isset($mcb) && count($mcb) > 0) {
				foreach ($mcb as $key=>$func) {
					list($a, $b) = $this->_mCallbackParameters[$name][$key];
					$delegate->add($func, $a, $b);
				}
			}

			return true;
		}
	}

	/**
	 * @public
	 * @brief Connects functions to the delegate that have the specified name.
	 * @param      $name string - Registration name.
	 * @param      $callback
	 * @param null $param3
	 * @param null $param4
	 * @return void
	 *
	 * If there aren't any delegates that have the specified name, this manager
	 * entrust parameters to member properties. Then, when the delegate that
	 * have the specified name will be registered, this manager will set these
	 * parameters to the delegate.
	 *
	 * @see XCube_Delegate::add()
	 */
	function add($name, $callback, $param3 = null, $param4 = null)
	{
		if (isset($this->_mDelegates[$name])) {
			foreach($this->_mDelegates[$name] as $func) {
				/** @var $func XCube_Delegate */
				$func->add($callback, $param3, $param4);
			}
		}
		$this->_mCallbacks[$name][] = $callback;
		$this->_mCallbackParameters[$name][] = array('0' => $param3, '1' => $param4);
	}

	/**
	 * @public
	 * @param $name       string - Registration name
	 * @param $delcallback* @brief Disconnects a function from the delegate that have the specified name.
	 * @see XCube_Delegate::delete()
	 */
	function delete($name, $delcallback)
	{
		if (isset($this->_mDelegates[$name])) {
			foreach(array_keys($this->_mDelegates[$name]) as $key) {
				$this->_mDelegates[$name][$key]->delete($delcallback);
			}
		}
		if (isset($this->_mCallbacks[$name])) {
			foreach(array_keys($this->_mCallbacks[$name]) as $key) {
				$callback = $this->_mCallbacks[$name][$key];
				if (XCube_DelegateUtils::_compareCallback($callback, $delcallback)) {
					unset($this->_mCallbacks[$name][$key]);
					unset($this->_mCallbackParameters[$name][$key]);
				}
			}
		}
	}

	/**
	 * @public
	 * @brief Resets all functions off the delegate that have the specified name.
	 * @param $name string - Registration name which will be resetted.
	 *
	 * @see XCube_Delegate::reset()
	 */
	function reset($name)
	{
		if (isset($this->_mDelegates[$name])) {
			foreach(array_keys($this->_mDelegates[$name]) as $key) {
				$this->_mDelegates[$name][$key]->reset();
			}
		}
		if (isset($this->_mCallbacks[$name])) {
			unset($this->_mCallbacks[$name]);
			unset($this->_mCallbackParameters[$name]);
		}
	}

	/**
	 * @public
	 * @brief Gets a value indicating whether the specified delegate has callback functions.
	 * @param string $name string - Registration name.
	 * @return bool
	 */
	function isEmpty($name)
	{
		if (isset($this->_mDelegates[$name])) {
			return $this->_mDelegates[$name]->isEmpty();
		}

		return isset($this->_mCallbacks[$name]) ? (count($this->_mCallbacks[$name]) == 0) : false;
	}

	/**
	 * @public
	 * @return array
	 */
	function getDelegates()
	{
		return $this->_mDelegates;
	}
}
