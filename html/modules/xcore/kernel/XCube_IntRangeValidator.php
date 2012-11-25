<?php

class XCube_IntRangeValidator extends XCube_Validator
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
