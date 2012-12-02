<?php

/**
 * @public
 * @brief [Abstract] Defines a interface for the property class group.
 * 
 * XCube_PropertyInterface is designed to work in XCube_ActionForm or Service (in the near future).
 * Therefore only sub-classes of them should call constructors of XCube_Property classes.
 */
use XCore\Kernel\Service;

class XCube_PropertyInterface
{
	/**
	 * @public
	 * @brief Constructor.
	 * @param $name string - A name of this property.
	 */
	function __construct($name)
	{
	}

	/**
	 * @public
	 * @brief [Abstract] Sets $value as raw value to this property. And the value is casted by the property's type'.
	 * @param $value mixed
	 */	
	function set($value)
	{
	}
	
	/**
	 * @public
	 * @brief [Abstract] Gets the value of this property.
	 * @return mixed
	 */
	function get()
	{
	}

	/**
	 * @deprecated
	 */	
	function setValue($arg0 = null, $arg1 = null)
	{
		$this->set($arg0, $arg1);
	}
	
	/**
	 * @deprecated
	 */	
	function getValue($arg0 = null)
	{
		return $this->get($arg0);
	}
	
	/**
	 * @public
	 * @brief [Abstract] Gets a value indicating whether this object expresses Array.
	 * @return bool
	 */
	function isArray()
	{
	}
	
	/**
	 * @public
	 * @brief [Abstract] Gets a value indicating whether this object is null.
	 * @return bool
	 */
	function isNull()
	{
	}
	
	/**
	 * @public
	 * @brief [Abstract] Gets a value as integer.
	 * @return int
	 */
	function toNumber()
	{
	}
	
	/**
	 * @public
	 * @brief [Abstract] Gets a value as string.
	 * @return string
	 */
	function toString()
	{
	}

	/**
	 * @public
	 * @brief [Abstract] Gets a value as encoded HTML code.
	 * @return string - HTML
	 * @deprecated
	 */	
	function toHTML()
	{
	}
	
	/**
	 * @public
	 * @brief [Abstract] Gets a value indicating whether this object has a fetch control.
	 * @return bool
	 */
	function hasFetchControl()
	{
	}

	/**
	 * @public [Abstract] Fetches values.
	 * @param $form XCube_ActionForm
	 * @return void
	 */	
	function fetch(&$form)
	{
	}
}
