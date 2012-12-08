<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\IntProperty;

class Xcore_SmilesAdminDeleteForm extends ActionForm
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
		$this->mFormProperties['id'] =new IntProperty('id');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['id'] =new FieldProperty($this);
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

