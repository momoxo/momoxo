<?php

class Xcore_ImageCreateAction extends Xcore_AbstractEditAction
{
	function _getId()
	{
		return 0;
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('image', 'xcore');
		return $handler;
	}

	function _setupActionForm()
	{
		$this->mActionForm =new Xcore_ImageAdminCreateForm();
		$this->mActionForm->prepare();
	}
	
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$flag = parent::getDefaultView($controller, $xoopsUser);
		
		if ($flag == XCORE_FRAME_VIEW_INPUT && $this->_enableCatchImgcat()) {
			$this->mActionForm->set('imgcat_id', xoops_getrequest('imgcat_id'));
		}
		
		return $flag;
	}
	
	function _enableCatchImgcat()
	{
		return true;
	}

	function _doExecute()
	{
		$handler =& xoops_getmodulehandler('imagecategory', 'xcore');
		$category =& $handler->get($this->mActionForm->get('imgcat_id'));
		
		//
		// [TODO]
		// Should the following procedure be after parent::_doExecute()?
		//
		if ($category->get('imgcat_storetype') == 'file') {
			$this->_storeFile();
		}
		else {
			$this->_storeDB();
		}
	
		return parent::_doExecute();
	}
	
	function _storeFile()
	{
		if ($this->mActionForm->mFormFile == null) {
			return null;
		}

		//
		// If there is a old file, delete it
		//
		if ($this->mActionForm->mOldFileName != null) {
			@unlink(XOOPS_UPLOAD_PATH . "/" . $this->mActionForm->mOldFileName);
			
			// Get a body name of the old file.
			$match = array();
			if (preg_match("/(.+)\.\w+$/", $this->mActionForm->mOldFileName, $match)) {
				$this->mActionForm->mFormFile->setBodyName($match[1]);
			}
		}
		
		$this->mObject->set('image_name', $this->mActionForm->mFormFile->getFileName());
		
		return $this->mActionForm->mFormFile->saveAs(XOOPS_UPLOAD_PATH);
	}
	
	function _storeDB()
	{
		
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$this->mObject->loadImagecategory();

		$render->setTemplateName("image_edit.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
		
		$handler =& xoops_getmodulehandler('imagecategory', 'xcore');
		$categoryArr =& $handler->getObjects();
		$render->setAttribute('categoryArr', $categoryArr);
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=ImageList&imgcat_id=" . $this->mActionForm->get('imgcat_id'));
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect("./index.php?action=ImagecategoryList", 1, _MD_XCORE_ERROR_DBUPDATE_FAILED);
	}
	
	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=ImagecategoryList");
	}
}

