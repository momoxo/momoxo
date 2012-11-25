<?php

/**
 *  This class defines a interface which XCube_ActionForm calls the check functions.
 *  But this class is designing now, you should not write a code which dependents
 * on the design of this class. We designed this class as static method class group
 * with a reason which a program can not generate many instance quickly. However,
 * if we will find better method to solve a problem, we will change it.
 *
 *  Don't use these classes directly, you should use XCube_ActionForm only.
 * This is 'protected' accesser in the namespace of XCube_ActionForm.
 */
class XCube_Validator
{
	/**
	 * 
	 * @param XCube_FormProperty $form
	 * @param array              $vars   variables of this field property.
	 * @return bool
	 */
	function isValid(&$form, $vars)
	{
	}
}
