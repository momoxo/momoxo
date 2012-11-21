<?php

class Xcore_TplfileViewAction extends Xcore_Action
{
	var $mObject = null;
	
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$id = xoops_getrequest('tpl_id');
		
		$handler =& xoops_getmodulehandler('tplfile');
		$this->mObject =& $handler->get($id);
		
		if (!is_object($this->mObject)) {
			return XCORE_FRAME_VIEW_ERROR;
		}
		
		return XCORE_FRAME_VIEW_SUCCESS;
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$this->mObject->loadSource();

		$render->setTemplateName("tplfile_view.html");
		$render->setAttribute('object', $this->mObject);
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect("./index.php?action=TplsetList", 1, _AD_XCORE_ERROR_OBJECT_IS_NOT_EXIST);
	}
}

?>