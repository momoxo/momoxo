<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\ImageFileProperty;
use XCore\Property\IntProperty;

class User_AvatarEditForm extends ActionForm
{
	var $mOldAvatarFilename = null;
	var $mFormFile = null;
	
	var $mWidth = 0;
	var $mHeight = 0;
	
	function getTokenName()
	{
		return "module.user.AvatarEditForm.TOKEN" . $this->get('uid');
	}

	function prepare($width, $height, $maxfilesize)
	{
		$this->mWidth = $width;
		$this->mHeight = $height;
		
		//
		// Set form properties
		//
		$this->mFormProperties['uid'] =new IntProperty('uid');
		$this->mFormProperties['uploadavatar'] =new ImageFileProperty('uploadavatar');

		//
		// Set field properties
		//
		$this->mFieldProperties['uploadavatar'] =new FieldProperty($this);
		$this->mFieldProperties['uploadavatar']->setDependsByArray(array('extension', 'maxfilesize'));
		$this->mFieldProperties['uploadavatar']->addMessage('extension', _MD_USER_ERROR_AVATAR_EXTENSION);
		$this->mFieldProperties['uploadavatar']->addVar('extension', "jpg,gif,png");
		$this->mFieldProperties['uploadavatar']->addMessage('maxfilesize', _MD_USER_ERROR_AVATAR_MAXFILESIZE);
		$this->mFieldProperties['uploadavatar']->addVar('maxfilesize', $maxfilesize);
	}

	function validateUploadavatar()
	{
		if ($this->get('uploadavatar') != null) {
		/*
			$formfile = $this->get('uploadavatar');
			if ($formfile->getWidth() > $this->mWidth) {
				$this->addErrorMessage(_MD_USER_ERROR_AVATAR_SIZE);
			}
			elseif ($formfile->getHeight() > $this->mHeight) {
				$this->addErrorMessage(_MD_USER_ERROR_AVATAR_SIZE);
			}
		*/
		}
	}
	
	function load(&$obj)
	{
		$this->set('uid', $obj->get('uid'));
		$this->mOldAvatarFilename = $obj->get('user_avatar');
	}

	function update(&$obj)
	{
		$obj->set('uid', $this->get('uid'));
		
		$this->mFormFile = $this->get('uploadavatar');

		if ($this->mFormFile != null) {
			$this->mFormFile->setRandomToBodyName('cavt');
			
			$filename = $this->mFormFile->getFileName();
			$this->mFormFile->setBodyName(substr($filename, 0, 25));
			
			$obj->set('user_avatar', $this->mFormFile->getFileName());	//< TODO
		}
	}

	/**
	 * @return UserAvatarObject
	 */
	function createAvatar()
	{
		$avatar = null;
		if ($this->mFormFile != null) {
			$avatarHandler =& xoops_getmodulehandler('avatar', 'user');
			$avatar =& $avatarHandler->create();
			$avatar->set('avatar_file', $this->mFormFile->getFileName());
			$avatar->set('avatar_mimetype', $this->mFormFile->getContentType());
			$avatar->set('avatar_type', 'C');
		}
		
		return $avatar;
	}
}
