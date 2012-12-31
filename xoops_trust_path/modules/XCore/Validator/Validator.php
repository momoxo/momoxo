<?php

namespace XCore\Validator;

use XCore\Form\ActionForm;
use XCore\Property\AbstractProperty;

/**
 *  This class defines a interface which ActionForm calls the check functions.
 *  But this class is designing now, you should not write a code which dependents
 * on the design of this class. We designed this class as static method class group
 * with a reason which a program can not generate many instance quickly. However,
 * if we will find better method to solve a problem, we will change it.
 *
 *  Don't use these classes directly, you should use ActionForm only.
 * This is 'protected' accessor in the namespace of ActionForm.
 */
class Validator
{
    /**
     *
     * @param  AbstractProperty $form
     * @param  array            $vars variables of this field property.
     * @return bool
     */
    public function isValid(&$form, $vars)
    {
    }
}
