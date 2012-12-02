<?php

use XCore\Validator\Validator;

class XCube_MaxfilesizeValidator extends Validator
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
			
			return ($form->mValue->getFileSize() <= $vars['maxfilesize']);
		}
	}
}
