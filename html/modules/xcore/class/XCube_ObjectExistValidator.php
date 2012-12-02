<?php

use XCore\Validator\Validator;

class XCube_ObjectExistValidator extends Validator
{
	function isValid(&$form, $vars)
	{
		if ($form->isNull()) {
			return true;
		}
		else {
			$handleName = $vars['handler'];
			$moduleName = isset($vars['module']) ? $vars['module'] : null;
			
			if ($moduleName == null) {
				$handler =& xoops_gethandler($handleName);
			}
			else {
				$handler =& xoops_getmodulehandler($handleName, $moduleName);
			}
			$obj =& $handler->get($form->getValue());
			
			return is_object($obj);
		}
	}
}
