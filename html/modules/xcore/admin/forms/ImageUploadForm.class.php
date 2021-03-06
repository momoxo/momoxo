<?php

use XCore\Kernel\Root;
use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\FileProperty;
use XCore\Property\IntProperty;

class Xcore_ImageUploadForm extends ActionForm
{
	var $mOldFileName = null;
	var $_mIsNew = null;
	var $mFormFile = null;
	var $_allowExtensions = array('tar', 'tar.gz', 'tgz', 'gz', 'zip');

	function getTokenName()
	{
		return "module.xcore.ImageUploadForm.TOKEN";
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['imgcat_id'] =new IntProperty('imgcat_id');
		$this->mFormProperties['upload'] =new FileProperty('upload');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['imgcat_id'] =new FieldProperty($this);
		$this->mFieldProperties['imgcat_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['imgcat_id']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_IMGCAT_ID);
		$this->mFieldProperties['upload'] =new FieldProperty($this);
		$this->mFieldProperties['upload']->setDependsByArray(array('required'));
		$this->mFieldProperties['upload']->addMessage('required', _AD_XCORE_ERROR_REQUIRED, _AD_XCORE_LANG_IMAGE_UPLOAD_FILE);
	
	}
	
	function validateImgcat_id()
	{

		$handler =& xoops_getmodulehandler('imagecategory', 'xcore');
		$imgcat_id = $this->get('imgcat_id');
		if ( !$imgcat_id || !$handler->get($imgcat_id) ) {
			$this->addErrorMessage(_AD_XCORE_LANG_IMGCAT_WRONG);
		}
		else {
			$root = Root::getSingleton();
			$xoopsUser =& $root->mController->mRoot->mContext->mXoopsUser;
			
			$groups = array();
			if (is_object($xoopsUser)) {
				$groups =& $xoopsUser->getGroups();
			}
			else {
				$groups = array(XOOPS_GROUP_ANONYMOUS);
			}
			$imgcat =& $handler->get($imgcat_id);
			if (is_object($imgcat) && !$imgcat->hasUploadPerm($groups)) {
				$this->addErrorMessage(_MD_XCORE_ERROR_PERMISSION);
			}

		}
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
				$this->addErrorMessage(_AD_XCORE_ERROR_EXTENSION_IS_WRONG);
			}
		}
	}
}

