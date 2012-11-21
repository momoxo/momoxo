<?php

class Xcore_ImageAdminDeleteForm extends XCube_ActionForm
{
	function getTokenName()
	{
		return "module.xcore.ImageAdminDeleteForm.TOKEN" . $this->get('image_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['image_id'] =new XCube_IntProperty('image_id');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['image_id'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['image_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['image_id']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_IMAGE_ID);
	}

	function load(&$obj)
	{
		$this->set('image_id', $obj->get('image_id'));
	}

	function update(&$obj)
	{
		$obj->set('image_id', $this->get('image_id'));
	}
}

?>
