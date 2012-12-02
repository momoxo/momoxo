<?php

use XCore\Validator\Validator;

class XCube_MaskValidator extends Validator
{
	function isValid(&$form, $vars)
	{
		if ($form->isNull()) {
			return true;
		}
		else {
			return preg_match($vars['mask'], $form->toString());
		}
	}
}
