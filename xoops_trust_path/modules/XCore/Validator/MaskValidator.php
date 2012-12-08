<?php

namespace XCore\Validator;

use XCore\Validator\Validator;

class MaskValidator extends Validator
{
    public function isValid(&$form, $vars)
    {
        if ( $form->isNull() ) {
            return true;
        } else {
            return preg_match($vars['mask'], $form->toString());
        }
    }
}
