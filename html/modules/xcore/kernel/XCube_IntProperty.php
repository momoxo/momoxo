<?php

/**
 * @public
 * @brief Represents int property. 
 */
class XCube_IntProperty extends XCube_AbstractProperty
{
	function set($value)
	{
		$this->mValue = trim($value)!==''?(int)$value:null;
	}
}
