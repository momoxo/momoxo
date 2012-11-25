<?php

class XCube_MaxfilesizeValidator extends XCube_Validator
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
