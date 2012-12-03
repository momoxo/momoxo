<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;

class User_MailjobAdminSendForm extends ActionForm
{
	function getTokenName()
	{
		return "module.user.MailjobAdminSendForm.TOKEN" . $this->get('mailjob_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['mailjob_id'] =new XCube_IntProperty('mailjob_id');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['mailjob_id'] =new FieldProperty($this);
		$this->mFieldProperties['mailjob_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['mailjob_id']->addMessage('required', _MD_USER_ERROR_REQUIRED, _AD_USER_LANG_MAILJOB_ID);
	}

	function load(&$obj)
	{
		$this->set('mailjob_id', $obj->get('mailjob_id'));
	}
}

?>
