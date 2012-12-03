<?php

use XCore\Form\ActionForm;

class Xcore_ModuleUninstallForm extends ActionForm
{
	function getTokenName()
	{
		return "module.xcore.ModuleUninstallForm.TOKEN." . $this->get('dirname');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['dirname'] =new XCube_StringProperty('dirname');
		$this->mFormProperties['force'] =new XCube_BoolProperty('force');
	}

	function load(&$obj)
	{
		$this->set('dirname', $obj->get('dirname'));
	}

	function update(&$obj)
	{
		$obj->set('dirname', $this->get('dirname'));
	}
}

