<?php

/**
 * @public
 * @brief Represents string property which allows CR and LF.
 *  
 *  This class shows the property of text. Check whether a request includes control
 * code. If it does, stop own process.
 */
class XCube_TextProperty extends XCube_AbstractProperty
{
	function set($value)
	{
		$this->mValue = preg_replace("/[\\x00-\\x08]|[\\x0b-\\x0c]|[\\x0e-\\x1f]/", '', $value);
	}
	
	function toNumber()
	{
		return (int)$this->mValue;
	}
}
