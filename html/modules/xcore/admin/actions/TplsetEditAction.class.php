<?php

class Xcore_TplsetEditAction extends Xcore_AbstractEditAction
{
	function _getId()
	{
		return xoops_getrequest('tplset_id');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('tplset');
		return $handler;
	}

	function _setupObject()
	{
		parent::_setupObject();

		if ($this->isAllowDefault() == false) {
			if (is_object($this->mObject) && $this->mObject->get('tplset_name') == 'default') {
				$this->mObject = null;
			}
		}
	}
	
	function _setupActionForm()
	{
		$this->mActionForm =new Xcore_TplsetEditForm();
		$this->mActionForm->prepare();
	}

	function isEnableCreate()
	{
		return false;
	}

	function isAllowDefault()
	{
		return false;
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("tplset_edit.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=TplsetList");
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect("./index.php?action=TplsetList", 1, _AD_XCORE_ERROR_DBUPDATE_FAILED);
	}

	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=TplsetList");
	}
}

