<?php

class XCube_MaskValidator extends XCube_Validator
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
