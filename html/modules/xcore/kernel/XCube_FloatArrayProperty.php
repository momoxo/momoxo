<?php

/**
 * @public
 * @brief Represents float[] property. XCube_GenericArrayProperty<XCube_FloatProperty>.
 * @see XCube_FloatProperty
 */
class XCube_FloatArrayProperty extends XCube_GenericArrayProperty
{
	function XCube_FloatArrayProperty($name)
	{
		parent::XCube_GenericArrayProperty("XCube_FloatProperty", $name);
	}
}
