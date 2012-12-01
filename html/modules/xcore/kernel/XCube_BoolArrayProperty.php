<?php

/**
 * @public
 * @brief Represents bool[] property. XCube_GenericArrayProperty<XCube_BoolProperty>.
 * @see XCube_BoolProperty
 */
class XCube_BoolArrayProperty extends XCube_GenericArrayProperty
{
	function __construct($name)
	{
		parent::__construct("XCube_BoolProperty", $name);
	}
}
