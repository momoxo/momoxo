<?php

use XCore\Kernel\Root;
use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;

class Xcore_ImageUploadForm extends ActionForm
{
	var $mOldFileName = null;
	var $_mIsNew = null;
	var $mFormFile = null;

	function getTokenName()
	{
		return "module.xcore.ImageUploadForm.TOKEN" . $this->get('imgcat_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['image_name'] =new XCube_ImageFileProperty('image_name');
		$this->mFormProperties['image_nicename'] =new XCube_StringProperty('image_nicename');
		$this->mFormProperties['imgcat_id'] =new XCube_IntProperty('imgcat_id');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['image_name'] =new FieldProperty($this);
		$this->mFieldProperties['image_name']->setDependsByArray(array('extension'));
		$this->mFieldProperties['image_name']->addVar('extension', 'jpg,gif,png');
	
		$this->mFieldProperties['image_nicename'] =new FieldProperty($this);
		$this->mFieldProperties['image_nicename']->setDependsByArray(array('required'));
		$this->mFieldProperties['image_nicename']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_IMAGE_NICENAME);
		
		$this->mFieldProperties['imgcat_id'] =new FieldProperty($this);
		$this->mFieldProperties['imgcat_id']->setDependsByArray(array('required','objectExist'));
		$this->mFieldProperties['imgcat_id']->addMessage('required', _MD_XCORE_ERROR_REQUIRED, _MD_XCORE_LANG_IMGCAT_ID);
		$this->mFieldProperties['imgcat_id']->addMessage('objectExist', _MD_XCORE_ERROR_OBJECTEXIST, _MD_XCORE_LANG_IMGCAT_ID);
		$this->mFieldProperties['imgcat_id']->addVar('handler', 'imagecategory');
		$this->mFieldProperties['imgcat_id']->addVar('module', 'xcore');
		
		// Fix the bug #1769768
		// https://sourceforge.net/tracker/?func=detail&aid=1769768&group_id=159211&atid=943471
		// The action form should not load language files and should be given resources
		// from outside. However, the ideal fix needs changing much message catalogs
		// including code which I can not edit. So I put the following code as an
		// exception.
		$root = Root::getSingleton();
		$root->mLanguageManager->loadModuleAdminMessageCatalog('xcore');
	}
	
	/**
	 * Check the permission of uploading.
	 */	
	function validateImgcat_id()
	{
		$imgcat_id = $this->get('imgcat_id');
		if ($imgcat_id != null) {
			$root = Root::getSingleton();
			$xoopsUser =& $root->mController->mRoot->mContext->mXoopsUser;
			
			$groups = array();
			if (is_object($xoopsUser)) {
				$groups =& $xoopsUser->getGroups();
			}
			else {
				$groups = array(XOOPS_GROUP_ANONYMOUS);
			}
			
			$handler =& xoops_getmodulehandler('imagecategory', 'xcore');
			$imgcat =& $handler->get($imgcat_id);
			if (is_object($imgcat) && !$imgcat->hasUploadPerm($groups)) {
				$this->addErrorMessage(_MD_XCORE_ERROR_PERMISSION);
			}
		}
	}

	function validateImage_name()
	{
		$formFile = $this->get('image_name');
		
		if ($formFile == null && $this->_mIsNew ) {
			$this->addErrorMessage(_MD_XCORE_ERROR_YOU_MUST_UPLOAD);
		}
	}
	
	function validate()
	{
		parent::validate();
		
		$handler =& xoops_getmodulehandler('imagecategory', 'xcore');
		$category =& $handler->get($this->get('imgcat_id'));
		
		$formFile = $this->get('image_name');

		if ($formFile != null && is_object($category)) {
			//
			// Imagefile width & height check.
			//
			if ($formFile->getWidth() > $category->get('imgcat_maxwidth') || $formFile->getHeight() > $category->get('imgcat_maxheight')) {
				$this->addErrorMessage(XCube_Utils::formatMessage(_AD_XCORE_ERROR_IMG_SIZE, $category->get('imgcat_maxwidth'), $category->get('imgcat_maxheight')));
			}
			
			//
			// Check file size
			//
			if ($formFile->getFilesize() > $category->get('imgcat_maxsize')) {
				$this->addErrorMessage(XCube_Utils::formatMessage(_AD_XCORE_ERROR_IMG_FILESIZE, $category->get('imgcat_maxsize')));
			}
		}
	}
	
	function load(&$obj)
	{
		$this->set('image_nicename', $obj->get('image_nicename'));
		$this->set('imgcat_id', $obj->get('imgcat_id'));
		
		$this->_mIsNew = $obj->isNew();
		$this->mOldFileName = $obj->get('image_name');
	}

	function update(&$obj)
	{
		$obj->set('image_nicename', $this->get('image_nicename'));
		$obj->set('image_display', true);
		$obj->set('imgcat_id', $this->get('imgcat_id'));
		
		$handler =& xoops_getmodulehandler('imagecategory', 'xcore');
		$category =& $handler->get($this->get('imgcat_id'));

		$this->mFormFile = $this->get('image_name');
		
		if ($this->mFormFile != null) {
			$this->mFormFile->setRandomToBodyName('img');
			
			$filename = $this->mFormFile->getBodyName();
			$this->mFormFile->setBodyName(substr($filename, 0, 24));
	
			$obj->set('image_name', $this->mFormFile->getFileName());
			$obj->set('image_mimetype', $this->mFormFile->getContentType());
			
			//
			// To store db
			//
			if ($category->get('imgcat_storetype') == 'db') {
				$obj->loadImageBody();
				if (!is_object($obj->mImageBody)) {
					$obj->mImageBody =& $obj->createImageBody();
				}
					
				//
				// Access to private member property.
				//
				$obj->mImageBody->set('image_body', file_get_contents($this->mFormFile->_mTmpFileName));
			}
		}
	}
}

