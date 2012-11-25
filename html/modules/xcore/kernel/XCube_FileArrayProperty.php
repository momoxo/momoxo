<?php

/**
 * @public
 * @brief Represents the special property[] which handles uploaded file. XCube_GenericArrayProperty<XCube_FileProperty>.
 * @see XCube_FileProperty
 */
class XCube_FileArrayProperty extends XCube_GenericArrayProperty
{
	function XCube_FileArrayProperty($name)
	{
		parent::XCube_GenericArrayProperty("XCube_FileProperty", $name);
	}
	
	function hasFetchControl()
	{
		return true;
	}
	
	function fetch(&$form)
	{
		unset($this->mProperties);
		$this->mProperties = array();
		if (isset($_FILES[$this->mName]) && is_array($_FILES[$this->mName]['name'])) {
			foreach ($_FILES[$this->mName]['name'] as $_key => $_val) {
				$this->mProperties[$_key] = new $this->mPropertyClassName($this->mName);
				$this->mProperties[$_key]->mIndex = $_key;
				$this->mProperties[$_key]->fetch($form);
			}
		}
	}
}
