<?php

use XCore\Validator\Validator;

class XCube_MinlengthValidator extends Validator
{
	function isValid(&$form, $vars)
	{
		if ($form->isNull()) {
			return true;
		}
		else {
			return strlen($form->toString()) >= $vars['minlength'];
		}
	}
}
