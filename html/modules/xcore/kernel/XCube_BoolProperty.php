<?php

/**
 * @public
 * @brief Represents bool property. 
 */
class XCube_BoolProperty extends XCube_AbstractProperty
{
	function set($value)
	{
		$this->mValue = (int)$value ? 1 : 0;
	}
}
