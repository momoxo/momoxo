<?php

class XCube_MinValidator extends XCube_Validator
{
	function isValid(&$form, $vars)
	{
		if ($form->isNull()) {
			return true;
		}
		else {
			return $form->toNumber() >= $vars['min'];
		}
	}
}
