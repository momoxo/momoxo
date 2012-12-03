<?php

use XCore\Form\ActionForm;

class Xcore_TplfileAdminDeleteForm extends ActionForm
{
	function getTokenName()
	{
		return "module.xcore.TplfileAdminDeleteForm.TOKEN";
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['tpl_id'] =new XCube_IntProperty('tpl_id');
	
		//
		// Set field properties
		//
	
		$this->mFieldProperties['tpl_id'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['tpl_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['tpl_id']->addMessage('required', _AD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_TPL_ID);
	}

	function load(&$obj)
	{
		$this->set('tpl_id', $obj->get('tpl_id'));
	}

	function update(&$obj)
	{
		$obj->set('tpl_id', $this->get('tpl_id'));
	}
}

