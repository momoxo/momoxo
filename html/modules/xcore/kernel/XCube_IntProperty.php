<?php

/**
 * @public
 * @brief Represents int property. 
 */
use XCore\Property\AbstractProperty;

class XCube_IntProperty extends AbstractProperty
{
	function set($value)
	{
		$this->mValue = trim($value)!==''?(int)$value:null;
	}
}
