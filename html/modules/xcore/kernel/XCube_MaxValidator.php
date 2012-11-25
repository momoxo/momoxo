<?php

class XCube_MaxValidator extends XCube_Validator
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
