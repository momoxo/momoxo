<?php

/**
 * @public
 * @brief This is extended XCube_FileProperty and limits uploaded files by image files.
 * @see XCube_FormImageFile
 */
class XCube_ImageFileProperty extends XCube_FileProperty
{
	function __construct($name)
	{
		parent::__construct($name);
		$this->mValue = new XCube_FormImageFile($name);
	}
}
