<?php

class Xcore_TplfileCloneAction extends Xcore_AbstractEditAction
{
	var $mTargetObject = null;
	
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
		$id = $this->_getId();
		
		$this->mObjectHandler =& $this->_getHandler();
		$obj =& $this->mObjectHandler->get($id);
		
		//
		// The following code uses 'tpl_tplset' directly. This input value will
		// be checked by ActionForm.
		//
		if (is_object($obj) && $obj->get('tpl_tplset') == 'default') {
			$this->mObject =& $obj->createClone(xoops_getrequest('tpl_tplset'));
		}
	}
	
	function isEnableCreate()
	{
		return false;
	}
	
	function _setupActionForm()
	{
		$this->mActionForm =new Xcore_TplfileCloneForm();
		$this->mActionForm->prepare();
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("tplfile_clone.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
		$render->setAttribute('tpl_id', xoops_getrequest('tpl_id'));
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$tplset = $this->mObject->get('tpl_tplset');
		$module = $this->mObject->get('tpl_module');
		$controller->executeForward("./index.php?action=TplfileList&tpl_tplset=${tplset}&tpl_module=${module}");
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect("./index.php?action=TplsetList", 1, _AD_XCORE_ERROR_DBUPDATE_FAILED);
	}
}

?>
