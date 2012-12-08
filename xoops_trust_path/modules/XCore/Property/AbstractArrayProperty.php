<?php

namespace XCore\Property;

use XCore\Property\GenericArrayProperty;

/**
 * @internal
 * @deprecated
 */
class AbstractArrayProperty extends GenericArrayProperty
{
    /**
     * @param string $name
     */
    public function __construct($name)
	{
		parent::__construct($this->mPropertyClassName, $name);
	}
}
