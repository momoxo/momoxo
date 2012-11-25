<?php

/**
 * @public
 * @brief  XCube_GenericArrayProperty<XCube_ImageFileProperty>.
 * @see XCube_ImageFileProperty
 */
class XCube_ImageFileArrayProperty extends XCube_FileArrayProperty
{
	function XCube_ImageFileArrayProperty($name)
	{
		parent::XCube_GenericArrayProperty("XCube_ImageFileProperty", $name);
	}
}
