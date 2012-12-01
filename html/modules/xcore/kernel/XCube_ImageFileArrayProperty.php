<?php

/**
 * @public
 * @brief  XCube_GenericArrayProperty<XCube_ImageFileProperty>.
 * @see XCube_ImageFileProperty
 */
class XCube_ImageFileArrayProperty extends XCube_FileArrayProperty
{
	function __construct($name)
	{
		parent::__construct("XCube_ImageFileProperty", $name);
	}
}
