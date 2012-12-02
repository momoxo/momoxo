<?php

use XCore\Validator\Validator;

class XCube_ExtensionValidator extends Validator
{
	function isValid(&$form, $vars)
	{
		if ($form->isNull()) {
			return true;
		}
		else {
			if (!is_a($form, "XCube_FileProperty")) {
				return true;
			}
			
			$extArr = explode(",", $vars['extension']);
			foreach ($extArr as $ext) {
				if (strtolower($form->mValue->getExtension()) == strtolower($ext)) {
					return true;
				}
			}
			
			return false;
		}
	}
}
