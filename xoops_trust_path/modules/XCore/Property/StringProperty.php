<?php

namespace XCore\Property;

use XCore\Property\AbstractProperty;

/**
 * Represents string property.
 *
 * This class shows the property of string. Check whether a request includes control
 * code. If it does, stop own process.
 */
class StringProperty extends AbstractProperty
{
    public function set($value)
    {
        $this->mValue = preg_replace("/[\\x00-\\x1f]/", '' , $value);
    }

    public function toNumber()
    {
        return (int) $this->mValue;
    }
}
