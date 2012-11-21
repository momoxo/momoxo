<?php

class Xcore_ImagecategoryAdminDeleteForm extends XCube_ActionForm
{
	function getTokenName()
	{
		return "module.xcore.ImagecategoryAdminDeleteForm.TOKEN" . $this->get('imgcat_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['imgcat_id'] =new XCube_IntProperty('imgcat_id');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['imgcat_id'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['imgcat_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['imgcat_id']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_IMGCAT_ID);
	}

	function load(&$obj)
	{
		$this->set('imgcat_id', $obj->get('imgcat_id'));
	}

	function update(&$obj)
	{
		$obj->set('imgcat_id', $this->get('imgcat_id'));
	}
}

?>
