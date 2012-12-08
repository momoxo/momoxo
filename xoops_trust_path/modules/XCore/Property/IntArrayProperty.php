<?php

namespace XCore\Property;

use XCore\Property\GenericArrayProperty;
use XCore\Property\IntProperty;

/**
 * Represents int[] property. GenericArrayProperty<IntProperty>.
 * @see IntProperty
 */
class IntArrayProperty extends GenericArrayProperty
{
	public function __construct($name)
	{
		parent::__construct('XCore\Property\IntProperty', $name);
	}
}
