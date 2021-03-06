<?php

namespace XCore\Validator;

use XCore\Validator\Validator;
use XCore\Property\FileProperty;

class MaxfilesizeValidator extends Validator
{
    public function isValid(&$form, $vars)
    {
        if ( $form->isNull() ) {
            return true;
        } else {
            if ( ($form instanceof FileProperty) === false ) {
                return true;
            }

            return ($form->mValue->getFileSize() <= $vars['maxfilesize']);
        }
    }
}
