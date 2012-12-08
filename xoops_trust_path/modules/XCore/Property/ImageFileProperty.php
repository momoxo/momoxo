<?php
namespace XCore\Property;

use XCore\Property\FileProperty;
use XCore\FormFile\FormImageFile;

/**
 * This is extended FileProperty and limits uploaded files by image files.
 * @see FormImageFile
 */
class ImageFileProperty extends FileProperty
{
	public function __construct($name)
	{
		parent::__construct($name);
		$this->mValue = new FormImageFile($name);
	}
}
