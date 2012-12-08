<?php

namespace XCore\Property;

use XCore\Property\AbstractProperty;

/**
 * Represents int property.
 */
class IntProperty extends AbstractProperty
{
	public function set($value)
	{
		$this->mValue = trim($value)!==''?(int)$value:null;
	}
}
