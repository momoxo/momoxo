<?php

namespace XCore\Property;

use XCore\Property\PropertyInterface;
use XCore\FormFile\FormFile;

/**
 * The base class which implements PropertyInterface, for all properties.
 */
abstract class AbstractProperty extends PropertyInterface
{
    /**
     * @var string
     */
    protected $mName = null;

    /**
     * @var FormFile|string
     * @todo クライアントコードからの直接参照を直して protected にする
     */
    public $mValue;

    /**
     * Constructor.
     * @param string $name A name of this property.
     */
    public function __construct($name)
    {
        parent::__construct($name);
        $this->mName = $name;
    }

    /**
     * Sets $value as raw value to this property. And the value is casted by the property's type'.
     * @param mixed $value
     */
    public function set($value)
    {
        $this->mValue = $value;
    }

    /**
     * Gets the value of this property.
     * @param  string|int $index
     * @return mixed
     */
    public function get($index = null)
    {
        return $this->mValue;
    }

    /**
     * Gets a value indicating whether this object expresses Array.
     *
     * Remarks:
     * This class is a base class for none-array properties, so a sub-class of this
     * does not override this method.
     *
     * @return bool
     */
    public function isArray()
    {
        return false;
    }

    /**
     * Gets a value indicating whether this object is null.
     * @return bool
     */
    public function isNull()
    {
        return (strlen(trim($this->mValue)) == 0);
    }

    /**
     * Gets a value as integer.
     * @return int
     */
    public function toNumber()
    {
        return $this->mValue;
    }

    /**
     * Gets a value as string.
     * @return string
     */
    public function toString()
    {
        return $this->mValue;
    }

    /**
     * Gets a value as encoded HTML code.
     * @return string HTML
     * @deprecated
     */
    public function toHTML()
    {
        return htmlspecialchars($this->toString(), ENT_QUOTES);
    }

    /**
     * Gets a value indicating whether this object has a fetch control.
     * @return bool
     */
    public function hasFetchControl()
    {
        return false;
    }
}
