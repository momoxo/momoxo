<?php

namespace XCore\Validator;

use XCore\Validator\Validator;

class MaxlengthValidator extends Validator
{
    public function isValid(&$form, $vars)
    {
        if ( $form->isNull() ) {
            return true;
        } else {
            return strlen($form->toString()) <= $vars['maxlength'];
        }
    }
}
