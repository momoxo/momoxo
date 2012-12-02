<?php

use XCore\Validator\Validator;

class XCube_MaxlengthValidator extends Validator
{
	function isValid(&$form, $vars)
	{
		if ($form->isNull()) {
			return true;
		}
		else {
			return strlen($form->toString()) <= $vars['maxlength'];
		}
	}
}
