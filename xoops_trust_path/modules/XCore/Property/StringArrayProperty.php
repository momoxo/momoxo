<?php

namespace XCore\Property;

use XCore\Property\GenericArrayProperty;
use XCore\Property\StringProperty;

/**
 * Represents string[] property. GenericArrayProperty<StringProperty>.
 * @see StringProperty
 */
class StringArrayProperty extends GenericArrayProperty
{
    public function __construct($name)
    {
        parent::__construct('XCore\Property\StringProperty', $name);
    }
}
