<?php

namespace XCore\Property;

use XCore\Property\AbstractProperty;

/**
 * Represents float property.
 */
class FloatProperty extends AbstractProperty
{
    public function set($value)
    {
        $this->mValue = trim($value)!== ''?(float) $value:null;
    }
}
