<?php

class Xcore_Action
{
	/**
	 * @access private
	 */
	var $_mAdminFlag = false;
	
	function __construct($adminFlag = false)
	{
		$this->_mAdminFlag = $adminFlag;
	}

	function hasPermission(&$controller, &$xoopsUser)
	{
		if ($this->_mAdminFlag) {
			return $controller->mRoot->mContext->mUser->isInRole('Module.xcore.Admin');
		}
		else {
			//
			// TODO Really?
			//
			return true;
		}
	}
	
	function prepare(&$controller, &$xoopsUser)
	{
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		return XCORE_FRAME_VIEW_NONE;
	}

	function execute(&$controller, &$xoopsUser)
	{
		return XCORE_FRAME_VIEW_NONE;
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
	}

	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
	}

	function executeViewPreview(&$controller, &$xoopsUser, &$render)
	{
	}

	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
	}
}
