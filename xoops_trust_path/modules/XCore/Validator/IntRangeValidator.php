<?php

namespace XCore\Validator;

use XCore\Validator\Validator;

class IntRangeValidator extends Validator
{
	public function isValid(&$form, $vars)
	{
		if ( $form->isNull() ) {
			return true;
		} else {
			return (intval($form->toNumber()) >= $vars['min'] && intval($form->toNumber()) <= $vars['max']);
		}
	}
}
