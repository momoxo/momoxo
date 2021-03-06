<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\FileProperty;

class User_AvatarUploadForm extends ActionForm
{
	var $mOldFileName = null;
	var $_mIsNew = null;
	var $mFormFile = null;
	var $_allowExtensions = array('tar', 'tar.gz', 'tgz', 'gz', 'zip');

	function getTokenName()
	{
		return "module.user.AvatarUploadForm.TOKEN";
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['upload'] =new FileProperty('upload');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['upload'] =new FieldProperty($this);
		$this->mFieldProperties['upload']->setDependsByArray(array('required'));
		$this->mFieldProperties['upload']->addMessage('required', _AD_USER_ERROR_REQUIRED, _AD_USER_LANG_AVATAR_UPLOAD_FILE);
	
	}
	
	function validateUpload()
	{
		$formFile = $this->get('upload');
		if ($formFile != null) {
			$flag = false;
			foreach ($this->_allowExtensions as $ext) {
				$flag |= preg_match("/" . str_replace(".", "\.", $ext) . "$/", $formFile->getFileName());
			}
			
			if (!$flag) {
				$this->addErrorMessage(_AD_USER_ERROR_EXTENSION_IS_WRONG);
			}
		}
	}
}

?>
