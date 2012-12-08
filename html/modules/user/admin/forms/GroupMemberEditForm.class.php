<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\IntArrayProperty;
use XCore\Property\IntProperty;

class User_GroupMemberEditForm extends ActionForm
{
	function getTokenName()
	{
		return "module.user.GroupMemberEditForm.TOKEN";
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['groupid'] =new IntProperty('groupid');
		$this->mFormProperties['uid'] =new IntArrayProperty('uid');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['uid'] =new FieldProperty($this);
		$this->mFieldProperties['uid']->setDependsByArray(array('intRange'));
		$this->mFieldProperties['uid']->addMessage('intRange', _AD_USER_ERROR_REQUEST_IS_WRONG);
		$this->mFieldProperties['uid']->addVar('min', '1');
		$this->mFieldProperties['uid']->addVar('max', '2');
	}
}

?>
