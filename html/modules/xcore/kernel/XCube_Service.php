<?php

/**
 * @public
 * @brief [Abstract] This class is a collection for functions.
 * 
 * @bug This class does NOT work perfectly. It's fatal...
 * @todo Fix fatal bugs.
 */
class XCube_Service
{
	/**
	 * @protected
	 * @brief string
	 */
	var $mServiceName = "";
	
	/**
	 * @protected
	 * @brief string
	 */
	var $mNameSpace = "";
	
	/**
	 * @protected
	 */
	var $mClassName = "XCube_Service";
	
	/**
	 * @protected
	 * @brief XCube_ActionStrategy(?) --- 'deprecated'
	 * @deprecated
	 */
	var $_mActionStrategy = null;
	
	var $_mTypes = array();
	
	var $_mFunctions = array();
	
	function __construct()
	{
	}
	
	function prepare()
	{
	}
	
	function addType($className)
	{
		$this->_mTypes[] = $className;
	}
	
	function addFunction()
	{
		$args = func_get_args();
		$n = func_num_args();
		$arg0 = &$args[0];

		if ($n == 3) {
			$this->_addFunctionStandard($arg0, $args[1], $args[2]);
		}
		elseif ($n == 1 && is_array($arg0)) {
			$this->_addFunctionStandard($arg0['name'], $arg0['in'], $arg0['out']);
		}
	}
	
	function _addFunctionStandard($name, $in, $out)
	{
		$this->_mFunctions[$name] = array(
			'out' => $out,
			'name' => $name,
			'in' => $in
		);
	}

	/**
	 * @var   string          $name
	 * @param XCube_Procedure $procedure
	 */	
	function register($name, &$procedure)
	{
	}
}
