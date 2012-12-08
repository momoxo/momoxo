<?php
namespace XCore\Property;

use XCore\Property\FileProperty;

/**
 * This is extended FileProperty and limits uploaded files by image files.
 * @see XCube_FormImageFile
 */
class ImageFileProperty extends FileProperty
{
	public function __construct($name)
	{
		parent::__construct($name);
		$this->mValue = new XCube_FormImageFile($name);
	}
}
