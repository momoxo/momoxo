<?php

class XCube_MaxlengthValidator extends XCube_Validator
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
