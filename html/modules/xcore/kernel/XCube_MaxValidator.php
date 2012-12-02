<?php

use XCore\Validator\Validator;

class XCube_MaxValidator extends Validator
{
	function isValid(&$form, $vars)
	{
		if ($form->isNull()) {
			return true;
		}
		else {
			return $form->toNumber() <= $vars['max'];
		}
	}
}
