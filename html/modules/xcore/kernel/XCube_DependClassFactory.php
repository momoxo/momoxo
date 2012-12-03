<?php

use XCore\Validator\Validator;
use XCore\Form\ActionForm;

/**
 * @internal
 * @public
 * @brief Factory for generating validator objects.
 * @attention
 *     Only 'ActionForm' class should use this class.
 */
class XCube_DependClassFactory
{
	/**
	 * @public
	 * @internal
	 * @brief [static] Gets a Validator object by the rule name (depend name).
	 * @param $dependName string
	 * @return Validator
	 * @attention
	 *     Only 'ActionForm' class should use this class.
	 */
	public static function &factoryClass($dependName)
	{
		static $_cache;
		
		if (!is_array($_cache)) {
			$_cache = array();
		}
		
		if (!isset($_cache[$dependName])) {
			// or switch?
			$class_name = "XCube_" . ucfirst($dependName) . "Validator";
			$_cache[$dependName] = new $class_name();
		}

		return $_cache[$dependName];
	}
}
