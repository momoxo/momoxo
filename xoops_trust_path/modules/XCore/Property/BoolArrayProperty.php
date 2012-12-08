<?php

namespace XCore\Property;

use XCore\Property\BoolProperty;
use XCore\Property\GenericArrayProperty;

/**
 * @see BoolProperty
 */
class BoolArrayProperty extends GenericArrayProperty
{
	public function __construct($name)
	{
		parent::__construct('XCore\Property\BoolProperty', $name);
	}
}
