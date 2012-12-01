<?php

/**
 * @public
 * @brief [Final] This class is an expression of reference in delegation mechanism for PHP4.
 * 
 * This class is adapt reference pointer for XCube_Delegate. Because XCube_Delegate is
 * virtual function pointers, it's impossible to hand variables as references to
 * XCube_Delegate::call(). In a such case, use this class as an adapter.
 * 
 * \code
 *   $object = new Object;
 *   $delegate->call($object); // In PHP4, functions will receive the copied value of $object.
 * 
 *   $object = new Object;
 *   $delegate->call(new XCube_Delegate($object)); // In PHP4, functions will receive the object.
 * \endcode
 */
use XCore\Kernel\DelegateManager;

class XCube_Ref
{
	/**
	 * @private
	 * @brief mixed
	 */
	var $_mObject = null;

	/**
	 * @public Constructor.
	 * @param $obj mixed
	 */
	function __construct(&$obj)
	{
		$this->_mObject =& $obj;
	}

	/**
	 * @public
	 * @internal
	 * @brief [Secret Agreement] Gets the value which this class is adapting.
	 * @return mixed
	 * @attention
	 *     Only XCube_Delegate & DelegateManager should call this method.
	 */
	function &getObject()
	{
		return $this->_mObject;
	}
}
