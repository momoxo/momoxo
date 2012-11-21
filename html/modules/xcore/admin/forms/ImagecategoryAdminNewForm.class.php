<?php

class Xcore_ImagecategoryAdminNewForm extends Xcore_ImagecategoryAdminEditForm
{
	function getTokenName()
	{
		return "module.xcore.ImagecategoryAdminNewForm.TOKEN";
	}

	function prepare()
	{
		parent::prepare();
		
		//
		// Set form properties
		//
		$this->mFormProperties['imgcat_storetype'] =new XCube_StringProperty('imgcat_storetype');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['imgcat_storetype'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['imgcat_storetype']->setDependsByArray(array('required','mask'));
		$this->mFieldProperties['imgcat_storetype']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_IMGCAT_STORETYPE);
		$this->mFieldProperties['imgcat_storetype']->addMessage('mask', _MD_XCORE_ERROR_MASK, _AD_XCORE_LANG_IMGCAT_STORETYPE);
		$this->mFieldProperties['imgcat_storetype']->addVar('mask', '/^(file|db)$/');
	}
	
	function load(&$obj)
	{
		parent::load($obj);
		$this->set('imgcat_storetype', $obj->get('imgcat_storetype'));
	}

	function update(&$obj)
	{
		parent::update($obj);
		$obj->set('imgcat_storetype', $this->get('imgcat_storetype'));
	}
}

?>
