<?php

/**
 * @public
 * @brief Represents float[] property. XCube_GenericArrayProperty<XCube_FloatProperty>.
 * @see XCube_FloatProperty
 */
class XCube_FloatArrayProperty extends XCube_GenericArrayProperty
{
	function __construct($name)
	{
		parent::__construct("XCube_FloatProperty", $name);
	}
}
