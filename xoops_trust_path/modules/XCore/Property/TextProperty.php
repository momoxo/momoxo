<?php

namespace XCore\Property;

use XCore\Property\AbstractProperty;

/**
 * Represents string property which allows CR and LF.
 *
 * This class shows the property of text. Check whether a request includes control
 * code. If it does, stop own process.
 */
class TextProperty extends AbstractProperty
{
    public function set($value)
    {
        $this->mValue = preg_replace("/[\\x00-\\x08]|[\\x0b-\\x0c]|[\\x0e-\\x1f]/", '', $value);
    }

    public function toNumber()
    {
        return (int) $this->mValue;
    }
}
