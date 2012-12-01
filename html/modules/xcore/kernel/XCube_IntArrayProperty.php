<?php

/**
 * @public
 * @brief Represents int[] property. XCube_GenericArrayProperty<XCube_IntProperty>.
 * @see XCube_IntProperty
 */
class XCube_IntArrayProperty extends XCube_GenericArrayProperty
{
	function __construct($name)
	{
		parent::__construct("XCube_IntProperty", $name);
	}
}
