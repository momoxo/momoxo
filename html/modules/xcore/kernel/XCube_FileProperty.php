<?php

/**
 * @public
 * @brief Represents the special property which handles uploaded file.
 * @see XCube_FormFile
 */
use XCore\Property\AbstractProperty;

class XCube_FileProperty extends AbstractProperty
{
	/**
	 * @protected
	 * @brief mixed - ID for XCube_FileArrayProperty.
	 * 
	 * friend XCube_FileArrayProperty;
	 */
	var $mIndex = null;
	
	function __construct($name)
	{
		parent::__construct($name);
		$this->mValue = new XCube_FormFile($name);
	}
	
	function hasFetchControl()
	{
		return true;
	}
	
	function fetch(&$form)
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
	
	function isNull()
	{
		if (!is_object($this->mValue)) {
			return true;
		}
		
		return !$this->mValue->hasUploadFile();
	}
	
	function toString()
	{
		return null;
	}
	
	function toNumber()
	{
		return null;
	}
}
