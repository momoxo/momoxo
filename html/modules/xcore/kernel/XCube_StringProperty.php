<?php

/**
 * @public
 * @brief Represents string property. 
 * 
 * This class shows the property of string. Check whether a request includes control
 * code. If it does, stop own process.
 */
class XCube_StringProperty extends XCube_AbstractProperty
{
	function set($value)
	{
		$this->mValue = preg_replace("/[\\x00-\\x1f]/", '' , $value);
	}
	
	function toNumber()
	{
		return (int)$this->mValue;
	}
}
