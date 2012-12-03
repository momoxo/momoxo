<?php

use XCore\Form\ActionForm;

class User_LostPassEditForm extends ActionForm
{
	function getTokenName()
	{
		return "module.user.LostPassEditForm.TOKEN";
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['email'] =new XCube_StringProperty('email');
		$this->mFormProperties['code'] =new XCube_StringProperty('code');

		//
		// Set field properties
		//
		$this->mFieldProperties['email'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['email']->setDependsByArray(array('required', 'email'));
		$this->mFieldProperties['email']->addMessage('required', _MD_USER_ERROR_REQUIRED, _MD_USER_LANG_EMAIL);
		$this->mFieldProperties['email']->addMessage('email', _MD_USER_ERROR_EMAIL, _MD_USER_LANG_EMAIL);
	}
}
