<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;

class User_RecountForm extends ActionForm
{
	function getTokenName()
	{
		return "module.user.RecountForm.TOKEN" . $this->get('uid');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['uid'] =new XCube_IntProperty('uid');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['uid'] =new FieldProperty($this);
		$this->mFieldProperties['uid']->setDependsByArray(array('required','objectExist'));
		$this->mFieldProperties['uid']->addMessage('required', _MD_USER_ERROR_REQUIRED, _MD_USER_LANG_UID);
		$this->mFieldProperties['uid']->addMessage('objectExist', _AD_USER_ERROR_OBJECTEXIST, _MD_USER_LANG_UID);
		$this->mFieldProperties['uid']->addVar('handler', 'users');
		$this->mFieldProperties['uid']->addVar('module', 'user');
	}

	function load(&$obj)
	{
		$this->set('uid', $obj->get('uid'));
	}

	function update(&$obj)
	{
		$obj->set('uid', $this->get('uid'));
	}
}

?>
