<?php

use XCore\Form\ActionForm;
use XCore\Property\BoolArrayProperty;

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
		$this->mFormProperties['system'] =new BoolArrayProperty('system');
		$this->mFormProperties['module'] =new BoolArrayProperty('module');
		$this->mFormProperties['module_admin'] =new BoolArrayProperty('module_admin');
		$this->mFormProperties['block'] =new BoolArrayProperty('block');
	
		//
		// Set field properties
		//
	}
}

?>
