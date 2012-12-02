<?php

use XCore\Validator\Validator;

class XCube_RequiredValidator extends Validator
{
	function isValid(&$form, $vars)
	{
		return !$form->isNull();
	}
}
