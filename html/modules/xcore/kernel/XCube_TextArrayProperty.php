<?php

/**
 * @public
 * @brief Represents string[] property which allows CR and LF. XCube_GenericArrayProperty<XCube_TextProperty>.
 * @see XCube_TextProperty
 */
class XCube_TextArrayProperty extends XCube_GenericArrayProperty
{
	function XCube_TextArrayProperty($name)
	{
		parent::XCube_GenericArrayProperty("XCube_TextProperty", $name);
	}
}
