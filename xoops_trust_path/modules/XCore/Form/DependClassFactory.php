<?php

namespace XCore\Form;

use XCore\Validator\Validator;
use XCore\Form\ActionForm;

/**
 * Factory for generating validator objects.
 * @attention
 *      Only 'ActionForm' class should use this class.
 * @see ActionForm
 */
class DependClassFactory
{
    /**
     * Gets a Validator object by the rule name (depend name).
     * @internal
     * @param  string    $dependName
     * @return Validator
     * @attention
     *      Only 'ActionForm' class should use this class.
     * @see ActionForm
     */
    public static function &factoryClass($dependName)
    {
        static $_cache;

        if ( !is_array($_cache) ) {
            $_cache = array();
        }

        if ( !isset($_cache[$dependName]) ) {
            // or switch?
            $class_name = sprintf('XCore\Validator\%sValidator', ucfirst($dependName));
            $_cache[$dependName] = new $class_name();
        }

        return $_cache[$dependName];
    }
}
