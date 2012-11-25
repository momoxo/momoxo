<?php

/**
 * @internal
 * @deprecated
 */
class XCube_AbstractArrayProperty extends XCube_GenericArrayProperty
{
	function XCube_AbstractArrayProperty($name)
	{
		parent::XCube_GenericArrayProperty($this->mPropertyClassName, $name);
	}
}
