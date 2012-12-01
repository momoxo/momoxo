<?php

/**
 * @internal
 * @deprecated
 */
class XCube_AbstractArrayProperty extends XCube_GenericArrayProperty
{
	function __construct($name)
	{
		parent::__construct($this->mPropertyClassName, $name);
	}
}
