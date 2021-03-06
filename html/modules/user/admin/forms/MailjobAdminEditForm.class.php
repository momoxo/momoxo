<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\BoolProperty;
use XCore\Property\IntProperty;
use XCore\Property\StringProperty;
use XCore\Property\TextProperty;
use XCore\Utils\Utils;

class User_MailjobAdminEditForm extends ActionForm
{
	function getTokenName()
	{
		return "module.user.MailjobAdminEditForm.TOKEN" . $this->get('mailjob_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['mailjob_id'] =new IntProperty('mailjob_id');
		$this->mFormProperties['title'] =new StringProperty('title');
		$this->mFormProperties['body'] =new TextProperty('body');
		$this->mFormProperties['from_name'] =new StringProperty('from_name');
		$this->mFormProperties['from_email'] =new StringProperty('from_email');
		$this->mFormProperties['is_pm'] =new BoolProperty('is_pm');
		$this->mFormProperties['is_mail'] =new BoolProperty('is_mail');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['mailjob_id'] =new FieldProperty($this);
		$this->mFieldProperties['mailjob_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['mailjob_id']->addMessage('required', _MD_USER_ERROR_REQUIRED, _AD_USER_LANG_MAILJOB_ID);
	
		$this->mFieldProperties['title'] =new FieldProperty($this);
		$this->mFieldProperties['title']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['title']->addMessage('required', _MD_USER_ERROR_REQUIRED, _AD_USER_LANG_TITLE, '255');
		$this->mFieldProperties['title']->addMessage('maxlength', _MD_USER_ERROR_MAXLENGTH, _AD_USER_LANG_TITLE, '255');
		$this->mFieldProperties['title']->addVar('maxlength', '255');
	
		$this->mFieldProperties['body'] =new FieldProperty($this);
		$this->mFieldProperties['body']->setDependsByArray(array('required'));
		$this->mFieldProperties['body']->addMessage('required', _MD_USER_ERROR_REQUIRED, _AD_USER_LANG_BODY);
	
		$this->mFieldProperties['from_name'] =new FieldProperty($this);
		$this->mFieldProperties['from_name']->setDependsByArray(array('maxlength'));
		$this->mFieldProperties['from_name']->addMessage('maxlength', _MD_USER_ERROR_MAXLENGTH, '255');
		$this->mFieldProperties['from_name']->addVar('maxlength', '255');
	
		$this->mFieldProperties['from_email'] =new FieldProperty($this);
		$this->mFieldProperties['from_email']->setDependsByArray(array('maxlength', 'email'));
		$this->mFieldProperties['from_email']->addMessage('maxlength', _MD_USER_ERROR_MAXLENGTH, '255');
		$this->mFieldProperties['from_email']->addVar('maxlength', '255');
		$this->mFieldProperties['from_email']->addMessage('email', _AD_USER_ERROR_EMAIL, _AD_USER_LANG_FROM_EMAIL);
	}
	
	function validateFrom_email()
	{
		if ($this->get('is_mail') && strlen($this->get('from_email')) == 0) {
			$this->addErrorMessage(Utils::formatMessage(_MD_USER_ERROR_REQUIRED, _AD_USER_LANG_FROM_EMAIL));
		}
	}
	
	function validate()
	{
		parent::validate();
		
		if (!$this->get('is_pm') && !$this->get('is_mail')) {
			$this->addErrorMessage(_AD_USER_ERROR_MAILJOB_SEND_MEANS);
		}
	}

	function load(&$obj)
	{
		$this->set('mailjob_id', $obj->get('mailjob_id'));
		$this->set('title', $obj->get('title'));
		$this->set('body', $obj->get('body'));
		$this->set('from_name', $obj->get('from_name'));
		$this->set('from_email', $obj->get('from_email'));
		$this->set('is_pm', $obj->get('is_pm'));
		$this->set('is_mail', $obj->get('is_mail'));
	}

	function update(&$obj)
	{
		$obj->set('mailjob_id', $this->get('mailjob_id'));
		$obj->set('title', $this->get('title'));
		$obj->set('body', $this->get('body'));
		$obj->set('from_name', $this->get('from_name'));
		$obj->set('from_email', $this->get('from_email'));
		$obj->set('is_pm', $this->get('is_pm'));
		$obj->set('is_mail', $this->get('is_mail'));
	}
}

?>
