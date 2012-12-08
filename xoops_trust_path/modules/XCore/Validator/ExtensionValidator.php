<?php

namespace XCore\Validator;

use XCore\Validator\Validator;
use XCore\Property\FileProperty;

class ExtensionValidator extends Validator
{
    public function isValid(&$form, $vars)
    {
        if ( $form->isNull() ) {
            return true;
        } else {
            if ( !is_a($form, "FileProperty") ) {
                return true;
            }

            $extArr = explode(",", $vars['extension']);
            foreach ($extArr as $ext) {
                if ( strtolower($form->mValue->getExtension()) == strtolower($ext) ) {
                    return true;
                }
            }

            return false;
        }
    }
}
