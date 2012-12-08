<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\IntProperty;

class User_UserAdminDeleteForm extends ActionForm
{
	function getTokenName()
	{
		return "module.user.UserAdminDeleteForm.TOKEN" . $this->get('uid');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['uid'] =new IntProperty('uid');

		//
		// Set field properties
		//
		$this->mFieldProperties['uid'] =new FieldProperty($this);
		$this->mFieldProperties['uid']->setDependsByArray(array('required'));
		$this->mFieldProperties['uid']->addMessage('required', _MD_USER_ERROR_REQUIRED, _MD_USER_LANG_UID);
	}

	function load(&$obj)
	{
		$this->set('uid', $obj->get('uid'));
	}

	function update(&$obj)
	{
		$obj->setVar('uid', $this->get('uid'));
	}
}

?>
