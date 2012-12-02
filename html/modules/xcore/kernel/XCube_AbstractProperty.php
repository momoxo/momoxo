<?php

use XCore\Property\PropertyInterface;

/**
 * @public
 * @brief [Abstract] The base class which implements PropertyInterface, for all properties.
 */
class XCube_AbstractProperty extends PropertyInterface
{
	/**
	 * @protected
	 * @brief string
	 */
	var $mName = null;
	
	/**
	 * @protected
	 * @brief string
	 */
	var $mValue = null;

	/**
	 * @public
	 * @brief Constructor.
	 * @param $name string - A name of this property.
	 */
	function __construct($name)
	{
		parent::__construct($name);
		$this->mName = $name;
	}
	
	/**
	 * @public
	 * @brief Sets $value as raw value to this property. And the value is casted by the property's type'.
	 * @param $value mixed
	 */	
	function set($value)
	{
		$this->mValue = $value;
	}
	
	/**
	 * @public
	 * @brief Gets the value of this property.
	 * @return mixed
	 */
	function get($index = null)
	{
		return $this->mValue;
	}
	
	/**
	 * @public
	 * @brief Gets a value indicating whether this object expresses Array.
	 * @return bool
	 * 
	 * @remarks
	 *     This class is a base class for none-array properties, so a sub-class of this
	 *     does not override this method.
	 */
	function isArray()
	{
		return false;
	}
	
	/**
	 * @public
	 * @brief Gets a value indicating whether this object is null.
	 * @return bool
	 */
	function isNull()
	{
		return (strlen(trim($this->mValue)) == 0);
	}
	
	/**
	 * @public
	 * @brief Gets a value as integer.
	 * @return int
	 */
	function toNumber()
	{
		return $this->mValue;
	}
	
	/**
	 * @public
	 * @brief Gets a value as string.
	 * @return string
	 */
	function toString()
	{
		return $this->mValue;
	}
	
	/**
	 * @public
	 * @brief Gets a value as encoded HTML code.
	 * @return string - HTML
	 * @deprecated
	 */	
	function toHTML()
	{
		return htmlspecialchars($this->toString(), ENT_QUOTES);
	}
	
	/**
	 * @public
	 * @brief Gets a value indicating whether this object has a fetch control.
	 * @return bool
	 */
	function hasFetchControl()
	{
		return false;
	}
}
