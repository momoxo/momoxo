<?php

/**
 * @public
 * @brief Represents string[] property. XCube_GenericArrayProperty<XCube_StringProperty>.
 * @see XCube_StringProperty
 */
class XCube_StringArrayProperty extends XCube_GenericArrayProperty
{
	function XCube_StringArrayProperty($name)
	{
		parent::XCube_GenericArrayProperty("XCube_StringProperty", $name);
	}
}
