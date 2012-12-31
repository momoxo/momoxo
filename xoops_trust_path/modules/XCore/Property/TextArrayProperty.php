<?php

namespace XCore\Property;

use XCore\Property\GenericArrayProperty;
use XCore\Property\TextProperty;

/**
 * Represents string[] property which allows CR and LF. GenericArrayProperty<TextProperty>.
 * @see TextProperty
 */
class TextArrayProperty extends GenericArrayProperty
{
    public function __construct($name)
    {
        parent::__construct('XCore\Property\TextProperty', $name);
    }
}
