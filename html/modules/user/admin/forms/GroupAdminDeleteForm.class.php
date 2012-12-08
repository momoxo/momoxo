<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\IntProperty;

class User_GroupAdminDeleteForm extends ActionForm
{
	function getTokenName()
	{
		return "module.user.GroupAdminDeleteForm.TOKEN" . $this->get('group_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['groupid'] =new IntProperty('groupid');

		//
		// Set field properties
		//
		$this->mFieldProperties['groupid'] =new FieldProperty($this);
		$this->mFieldProperties['groupid']->setDependsByArray(array('required'));
		$this->mFieldProperties['groupid']->addMessage('required', _MD_USER_ERROR_REQUIRED, _MD_USER_LANG_GROUPID);
	}
	
	function validateGroupid()
	{
		$groupid = $this->get('groupid');
		if ($groupid <= XOOPS_GROUP_ANONYMOUS) {
			$this->addErrorMessage("You can't delete this group.");
		}
	}

	function load(&$obj)
	{
		$this->set('groupid', $obj->get('groupid'));
	}

	function update(&$obj)
	{
		$obj->setVar('groupid', $this->get('groupid'));
	}
}

?>
