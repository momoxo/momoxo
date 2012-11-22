<?php

class Xcore_MiscFriendForm extends XCube_ActionForm
{
	function getTokenName()
	{
		return "module.xcore.MiscFriendForm.TOKEN";
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['yname'] =new XCube_StringProperty('yname');
		$this->mFormProperties['ymail'] =new XCube_StringProperty('ymail');
		$this->mFormProperties['fname'] =new XCube_StringProperty('fname');
		$this->mFormProperties['fmail'] =new XCube_StringProperty('fmail');
	
		//
		// Set field properties
		//
	
		$this->mFieldProperties['yname'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['yname']->setDependsByArray(array('required'));
		$this->mFieldProperties['yname']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_YNAME);
	
		$this->mFieldProperties['ymail'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['ymail']->setDependsByArray(array('required','email'));
		$this->mFieldProperties['ymail']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_YMAIL);
		$this->mFieldProperties['ymail']->addMessage('required', _MD_XCORE_ERROR_EMAIL, _MD_XCORE_LANG_YMAIL);
	
		$this->mFieldProperties['fname'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['fname']->setDependsByArray(array('required'));
		$this->mFieldProperties['fname']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_FNAME);
	
		$this->mFieldProperties['fmail'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['fmail']->setDependsByArray(array('required','email'));
		$this->mFieldProperties['fmail']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_FMAIL);
		$this->mFieldProperties['fmail']->addMessage('email', _MD_XCORE_ERROR_EMAIL, _MD_XCORE_LANG_FMAIL);
	}
	
	function load(&$user)
	{
		$this->set('yname', $user->get('uname'));
		$this->set('ymail', $user->get('email'));
	}
	
	function update(&$mailer)
	{
		$mailer->assign("YOUR_NAME", $this->get('yname'));
		$mailer->assign("FRIEND_NAME", $this->get('fname'));
		$mailer->setToEmails($this->get('fmail'));
		$mailer->setFromEmail($this->get('ymail'));
		$mailer->setFromName($this->get('yname'));
	}
}

