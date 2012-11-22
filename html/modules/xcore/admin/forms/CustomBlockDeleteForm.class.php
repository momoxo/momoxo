<?php

class Xcore_CustomBlockDeleteForm extends XCube_ActionForm
{
	function getTokenName()
	{
		return "module.xcore.CustomBlockDeleteForm.TOKEN" . $this->get('bid');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['bid'] =new XCube_IntProperty('bid');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['bid'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['bid']->setDependsByArray(array('required'));
		$this->mFieldProperties['bid']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_BID);
	}

	function load(&$obj)
	{
		$this->set('bid', $obj->get('bid'));
	}

	function update(&$obj)
	{
	}
}

