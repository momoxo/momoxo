<?php

use XCore\Validator\Validator;

class XCube_IntRangeValidator extends Validator
{
	function isValid(&$form, $vars)
	{
		if ($form->isNull()) {
			return true;
		}
		else {
			return (intval($form->toNumber()) >= $vars['min'] && intval($form->toNumber()) <= $vars['max']);
		}
	}
}
