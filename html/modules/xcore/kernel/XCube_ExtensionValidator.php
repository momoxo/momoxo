<?php

class XCube_ExtensionValidator extends XCube_Validator
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
