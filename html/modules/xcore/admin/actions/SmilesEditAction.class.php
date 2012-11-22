<?php

class Xcore_SmilesEditAction extends Xcore_AbstractEditAction
{
	function _getId()
	{
		return isset($_REQUEST['id']) ? xoops_getrequest('id') : 0;
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('smiles');
		return $handler;
	}

	function _setupActionForm()
	{
		$this->mActionForm =new Xcore_SmilesAdminEditForm();
		$this->mActionForm->prepare();
	}
	
	
	function _doExecute()
	{
		if ($this->mActionForm->mFormFile != null) {
			if (!$this->mActionForm->mFormFile->saveAs(XOOPS_UPLOAD_PATH)) {
				return false;
			}
		}

		//
		// Delete old file, if the file exists.
		//
		if ($this->mActionForm->mOldFilename != null && $this->mActionForm->mOldFilename != "blank.gif") {
			@unlink(XOOPS_UPLOAD_PATH . "/" . $this->mActionForm->mOldFilename);
		}

		return parent::_doExecute();
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("smiles_edit.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=SmilesList");
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect("./index.php?action=SmilesList", 1, _MD_XCORE_ERROR_DBUPDATE_FAILED);
	}
	
	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=SmilesList");
	}
}

