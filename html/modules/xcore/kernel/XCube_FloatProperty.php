<?php

/**
 * @public
 * @brief Represents float property. 
 */
use XCore\Property\AbstractProperty;

class XCube_FloatProperty extends AbstractProperty
{
	function set($value)
	{
		$this->mValue = trim($value)!== ''?(float)$value:null;
	}
}
