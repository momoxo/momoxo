<?php

/**
 * @public
 * @brief Represents bool[] property. XCube_GenericArrayProperty<XCube_BoolProperty>.
 * @see XCube_BoolProperty
 */
class XCube_BoolArrayProperty extends XCube_GenericArrayProperty
{
	function XCube_BoolArrayProperty($name)
	{
		parent::XCube_GenericArrayProperty("XCube_BoolProperty", $name);
	}
}
