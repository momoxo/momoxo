<?php

class Xcore_TplfileDeleteAction extends Xcore_AbstractDeleteAction
{
	function _getId()
	{
		return xoops_getrequest('tpl_id');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('tplfile');
		return $handler;
	}

	function _setupObject()
	{
		parent::_setupObject();
		if ($this->mObject != null && $this->mObject->get('tpl_tplset') == 'default') {
			$this->mObject = null;
		}
	}

	function _setupActionForm()
	{
		$this->mActionForm =new Xcore_TplfileAdminDeleteForm();
		$this->mActionForm->prepare();
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("tplfile_delete.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		$this->mObject->loadSource();
		$render->setAttribute('object', $this->mObject);
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$xoopsTpl =new XoopsTpl();
		$xoopsTpl->clear_cache('db:' . $this->mObject->get('tpl_file'));
		$xoopsTpl->clear_compiled_tpl('db:' . $this->mObject->get('tpl_file'));
		
		$tplset = $this->mObject->get('tpl_tplset');
		$module = $this->mObject->get('tpl_module');
		$controller->executeForward("./index.php?action=TplfileList&tpl_tplset=${tplset}&tpl_module=${module}");
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect("./index.php?action=TplfileList", 1, _AD_XCORE_ERROR_DBUPDATE_FAILED);
	}

	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$tplset = $this->mObject->get('tpl_tplset');
		$module = $this->mObject->get('tpl_module');
		$controller->executeForward("./index.php?action=TplfileList&tpl_tplset=${tplset}&tpl_module=${module}");
	}
}

