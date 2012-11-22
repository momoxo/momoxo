<?php

class Xcore_BlockUninstallAction extends Xcore_AbstractEditAction
{
	function _getId()
	{
		return isset($_REQUEST['bid']) ? xoops_getrequest('bid') : 0;
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('newblocks');
		return $handler;
	}

	function _setupActionForm()
	{
		$this->mActionForm =new Xcore_BlockUninstallForm();
		$this->mActionForm->prepare();
	}
	
	function _isEditable()
	{
		if (is_object($this->mObject)) {
			return ($this->mObject->get('visible') == 1);
		}
		else {
			return false;
		}
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("block_uninstall.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		
		//
		// lazy loading
		//
		$this->mObject->loadModule();
		$this->mObject->loadColumn();
		$this->mObject->loadCachetime();
		
		$render->setAttribute('object', $this->mObject);
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=BlockList");
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect("./index.php?action=BlockList", 1, _MD_XCORE_ERROR_DBUPDATE_FAILED);
	}
	
	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=BlockList");
	}
}

