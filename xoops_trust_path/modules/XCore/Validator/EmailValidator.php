<?php

namespace XCore\Validator;

use XCore\Validator\Validator;

class FormFile extends Validator
{
    public function isValid(&$form, $vars)
    {
        if ( $form->isNull() ) {
            return true;
        } else {
            return preg_match("/^[_a-z0-9\-+!#$%&'*\/=?^`{|}~]+(\.[_a-z0-9\-+!#$%&'*\/=?^`{|}~]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i", $form->toString());
        }
    }
}
