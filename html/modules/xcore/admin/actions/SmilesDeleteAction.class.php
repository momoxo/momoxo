<?php

class Xcore_SmilesDeleteAction extends Xcore_AbstractDeleteAction
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
		$this->mActionForm =new Xcore_SmilesAdminDeleteForm();
		$this->mActionForm->prepare();
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("smiles_delete.html");
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

