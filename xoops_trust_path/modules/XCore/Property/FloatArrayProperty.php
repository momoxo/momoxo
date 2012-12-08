<?php

namespace XCore\Property;

use XCore\Property\FloatProperty;
use XCore\Property\GenericArrayProperty;

/**
 * Represents float[] property. GenericArrayProperty<FloatProperty>.
 * @see FloatProperty
 */
class FloatArrayProperty extends GenericArrayProperty
{
	public function __construct($name)
	{
		parent::__construct('XCore\Property\FloatProperty', $name);
	}
}
