<?php

use XCore\Form\ActionForm;

class User_GroupPermEditForm extends ActionForm
{
	function getTokenName()
	{
		return "module.user.GroupPermEditForm.TOKEN";
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['system'] =new XCube_BoolArrayProperty('system');
		$this->mFormProperties['module'] =new XCube_BoolArrayProperty('module');
		$this->mFormProperties['module_admin'] =new XCube_BoolArrayProperty('module_admin');
		$this->mFormProperties['block'] =new XCube_BoolArrayProperty('block');
	
		//
		// Set field properties
		//
	}
}

?>
