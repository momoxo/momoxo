<?php

namespace XCore\Validator;

use XCore\Validator\Validator;

class RequiredValidator extends Validator
{
    public function isValid(&$form, $vars)
    {
        return !$form->isNull();
    }
}
