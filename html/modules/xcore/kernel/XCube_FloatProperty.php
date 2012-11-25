<?php

/**
 * @public
 * @brief Represents float property. 
 */
class XCube_FloatProperty extends XCube_AbstractProperty
{
	function set($value)
	{
		$this->mValue = trim($value)!== ''?(float)$value:null;
	}
}
