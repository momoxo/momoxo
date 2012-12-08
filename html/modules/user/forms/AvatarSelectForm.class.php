<?php

use XCore\Form\ActionForm;
use XCore\Property\IntArrayProperty;
use XCore\Property\IntProperty;

class User_AvatarSelectForm extends ActionForm
{
	var $mSelectedId = null;
	
	function getTokenName()
	{
		return "module.user.AvatarSelectForm.TOKEN" . $this->get('uid');
	}

	function prepare()
	{
		$this->mFormProperties['uid'] =new IntProperty('uid');
		$this->mFormProperties['avatar_id'] =new IntArrayProperty('avatar_id');
	}
	
	function validateAvatar_id()
	{
		$ids = $this->get('avatar_id');
		
		if (count($ids) != 1) {
			$this->addErrorMessage(_MD_USER_ERROR_AVATAR_SELECT);
		}
		
		foreach ($ids as $avatar_id => $dmy_value) {
			$this->mSelectedId = $avatar_id;
		}
		
		if ($this->mSelectedId == 0) {
			return;
		}
		
		//
		// Check whether specified avatar_id exists. 
		//
		$handler =& xoops_getmodulehandler('avatar', 'user');
		$obj =& $handler->get($this->mSelectedId);
		
		if (!is_object($obj)) {
			$this->addErrorMessage(_MD_USER_ERROR_AVATAR_SELECT);
		}
	}
	
	function load(&$obj)
	{
		$this->set('uid', $obj->get('uid'));
	}
	
	function update(&$obj)
	{
		$handler =& xoops_getmodulehandler('avatar', 'user');
		
		if ($this->mSelectedId == 0) {
			$obj->set('user_avatar', 'blank.gif');
		}
		else {
			$avatar =& $handler->get($this->mSelectedId);
			$obj->set('user_avatar', $avatar->get('avatar_file'));
		}
	}
}
