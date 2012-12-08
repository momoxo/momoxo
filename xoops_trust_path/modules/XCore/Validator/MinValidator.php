<?php

namespace XCore\Validator;

use XCore\Validator\Validator;

class MinValidator extends Validator
{
    public function isValid(&$form, $vars)
    {
        if ( $form->isNull() ) {
            return true;
        } else {
            return $form->toNumber() >= $vars['min'];
        }
    }
}
