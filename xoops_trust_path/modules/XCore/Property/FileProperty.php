<?php

namespace XCore\Property;

use XCore\Property\AbstractProperty;
use XCore\Property\FileArrayProperty;
use XCore\FormFile\FormFile;

/**
 * Represents the special property which handles uploaded file.
 * @see FormFile
 */
class FileProperty extends AbstractProperty
{
	/**
	 * ID for FileArrayProperty.
	 * @var mixed
	 * @see FileArrayProperty;
	 */
	protected $mIndex = null;
	
	public function __construct($name)
	{
		parent::__construct($name);
		$this->mValue = new FormFile($name);
	}
	
	public function hasFetchControl()
	{
		return true;
	}
	
	public function fetch(&$form)
	{
		if (!is_object($this->mValue)) {
			return false;
		}
		
		if ($this->mIndex !== null) {
			$this->mValue->mKey = $this->mIndex;
		}
		
		$this->mValue->fetch();
		
		if (!$this->mValue->hasUploadFile()) {
			$this->mValue = null;
		}
	}
	
	public function isNull()
	{
		if (!is_object($this->mValue)) {
			return true;
		}
		
		return !$this->mValue->hasUploadFile();
	}
	
	public function toString()
	{
		return null;
	}
	
	public function toNumber()
	{
		return null;
	}
}
