<?php

class XCube_RequiredValidator extends XCube_Validator
{
	function isValid(&$form, $vars)
	{
		return !$form->isNull();
	}
}
