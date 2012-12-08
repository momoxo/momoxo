<?php

use XCore\Validator\Validator;
use XCore\Property\FileProperty;

class XCube_MaxfilesizeValidator extends Validator
{
	function isValid(&$form, $vars)
	{
		if ($form->isNull()) {
			return true;
		}
		else {
			if (!is_a($form, "FileProperty")) {
				return true;
			}
			
			return ($form->mValue->getFileSize() <= $vars['maxfilesize']);
		}
	}
}
