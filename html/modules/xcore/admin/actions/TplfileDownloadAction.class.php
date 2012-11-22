<?php

class Xcore_TplfileDownloadAction extends Xcore_Action
{
	var $mObject = null;
	
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$id = xoops_getrequest('tpl_id');
		
		$handler =& xoops_getmodulehandler('tplfile');
		$this->mObject =& $handler->get($id);
		
		return $this->mObject != null ? XCORE_FRAME_VIEW_SUCCESS : XCORE_FRAME_VIEW_ERROR;
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$this->mObject->loadSource();
		if ($this->mObject->Source == null) {
			return XCORE_FRAME_VIEW_ERROR;
		}

		$source = $this->mObject->Source->get('tpl_source');
		
		header('Cache-Control: no-cache, must-revalidate');
		header('Pragma: no-cache');
		header('Content-Type: application/force-download');
		
		if (preg_match("/MSIE 5.5/", $_SERVER['HTTP_USER_AGENT'])) {
			header('Content-Disposition: filename=' . $this->mObject->getShow('tpl_file'));
		} else {
			header('Content-Disposition: attachment; filename=' . $this->mObject->getShow('tpl_file'));
		}

		header('Content-length: ' . strlen($source));
		print $source;
		
		exit(0); // need to response
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect("./index.php?action=TplsetList", 1, _AD_XCORE_ERROR_DBUPDATE_FAILED);
	}
}

