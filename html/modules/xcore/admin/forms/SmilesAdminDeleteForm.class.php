<?php

class Xcore_SmilesAdminDeleteForm extends XCube_ActionForm
{
	function getTokenName()
	{
		return "module.xcore.SmilesAdminDeleteForm.TOKEN" . $this->get('id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['id'] =new XCube_IntProperty('id');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['id'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['id']->setDependsByArray(array('required'));
		$this->mFieldProperties['id']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_ID);
	}

	function load(&$obj)
	{
		$this->set('id', $obj->get('id'));
	}

	function update(&$obj)
	{
		$obj->set('id', $this->get('id'));
	}
}

