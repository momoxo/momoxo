<?php

namespace XCore\Property;

use XCore\Property\AbstractProperty;

/**
 * Represents bool property.
 */
class BoolProperty extends AbstractProperty
{
    public function set($value)
    {
        $this->mValue = (int) $value ? 1 : 0;
    }
}
