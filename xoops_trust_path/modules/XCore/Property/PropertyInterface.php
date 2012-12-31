<?php

namespace XCore\Property;

use XCore\Kernel\Service;
use XCore\Form\ActionForm;

/**
 * Defines a interface for the property class group.
 *
 * PropertyInterface is designed to work in ActionForm or Service (in the near future).
 * Therefore only sub-classes of them should call constructors of Property classes.
 *
 * @todo abstract class ではなく interface にする
 */
abstract class PropertyInterface
{
    /**
     * Constructor.
     * @param string $name A name of this property.
     */
    public function __construct($name)
    {
    }

    /**
     * Sets $value as raw value to this property. And the value is casted by the property's type'.
     * @param $value mixed
     */
    public function set($value)
    {
        // abstract
    }

    /**
     * Gets the value of this property.
     * @return mixed
     */
    public function get()
    {
        // abstract
    }

    /**
     * @deprecated
     */
    public function setValue($arg0 = null, $arg1 = null)
    {
        $this->set($arg0, $arg1);
    }

    /**
     * @deprecated
     */
    public function getValue($arg0 = null)
    {
        return $this->get($arg0);
    }

    /**
     * Gets a value indicating whether this object expresses Array.
     * @return bool
     */
    public function isArray()
    {
        // abstract
    }

    /**
     * Gets a value indicating whether this object is null.
     * @return bool
     */
    public function isNull()
    {
        // abstract
    }

    /**
     * Gets a value as integer.
     * @return int
     */
    public function toNumber()
    {
        // abstract
    }

    /**
     * Gets a value as string.
     * @return string
     */
    public function toString()
    {
        // abstract
    }

    /**
     * Gets a value as encoded HTML code.
     * @deprecated
     * @return string HTML
     */
    public function toHTML()
    {
        // abstract
    }

    /**
     * Gets a value indicating whether this object has a fetch control.
     * @return bool
     */
    public function hasFetchControl()
    {
        // abstract
    }

    /**
     * Fetches values.
     * @param  ActionForm $form
     * @return void
     */
    public function fetch(&$form)
    {
        // abstract
    }
}
