<?php

/**
 * @public
 * @brief Represents bool property. 
 */
use XCore\Property\AbstractProperty;

class XCube_BoolProperty extends AbstractProperty
{
	function set($value)
	{
		$this->mValue = (int)$value ? 1 : 0;
	}
}
