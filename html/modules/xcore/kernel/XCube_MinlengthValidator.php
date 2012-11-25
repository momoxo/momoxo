<?php

class XCube_MinlengthValidator extends XCube_Validator
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
