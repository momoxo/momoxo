<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\IntProperty;

class User_AvatarAdminDeleteForm extends ActionForm
{
	function getTokenName()
	{
		return "module.user.AvatarAdminDeleteForm.TOKEN" . $this->get('avatar_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['avatar_id'] =new IntProperty('avatar_id');

		//
		// Set field properties
		//
		$this->mFieldProperties['avatar_id'] =new FieldProperty($this);
		$this->mFieldProperties['avatar_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['avatar_id']->addMessage('required', _MD_USER_ERROR_REQUIRED, _MD_USER_LANG_AVATAR_ID);
	}

	function load(&$obj)
	{
		$this->set('avatar_id', $obj->get('avatar_id'));
	}

	function update(&$obj)
	{
		$obj->setVar('avatar_id', $this->get('avatar_id'));
	}
}

?>
