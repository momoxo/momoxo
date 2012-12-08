<?php

use XCore\Form\ActionForm;
use XCore\Property\BoolProperty;
use XCore\Property\StringProperty;

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
		$this->mFormProperties['dirname'] =new StringProperty('dirname');
		$this->mFormProperties['force'] =new BoolProperty('force');
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

