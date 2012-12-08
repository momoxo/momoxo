<?php

namespace XCore\Validator;

use XCore\Validator\Validator;

class MinlengthValidator extends Validator
{
    public function isValid(&$form, $vars)
    {
        if ( $form->isNull() ) {
            return true;
        } else {
            return strlen($form->toString()) >= $vars['minlength'];
        }
    }
}
