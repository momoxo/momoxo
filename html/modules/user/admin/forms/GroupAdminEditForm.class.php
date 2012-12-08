<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\IntProperty;
use XCore\Property\StringProperty;
use XCore\Property\TextProperty;

class User_GroupAdminEditForm extends ActionForm
{
	function getTokenName()
	{
		return "module.user.GroupAdminEditForm.TOKEN" . $this->get('groupid');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['groupid'] =new IntProperty('groupid');
		$this->mFormProperties['name'] =new StringProperty('name');
		$this->mFormProperties['description'] =new TextProperty('description');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['groupid'] =new FieldProperty($this);
		$this->mFieldProperties['groupid']->setDependsByArray(array('required'));
		$this->mFieldProperties['groupid']->addMessage('required', _MD_USER_ERROR_REQUIRED, _MD_USER_LANG_GROUPID);
	
		$this->mFieldProperties['name'] =new FieldProperty($this);
		$this->mFieldProperties['name']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['name']->addMessage('required', _MD_USER_ERROR_REQUIRED, _AD_USER_LANG_GROUP_NAME, '50');
		$this->mFieldProperties['name']->addMessage('maxlength', _MD_USER_ERROR_MAXLENGTH, _AD_USER_LANG_GROUP_NAME, '50');
		$this->mFieldProperties['name']->addVar('maxlength', '50');
	}

	function load(&$obj)
	{
		$this->set('groupid', $obj->get('groupid'));
		$this->set('name', $obj->get('name'));
		$this->set('description', $obj->get('description'));
	}

	function update(&$obj)
	{
		$obj->set('groupid', $this->get('groupid'));
		$obj->set('name', $this->get('name'));
		$obj->set('description', $this->get('description'));
	}
}

?>
