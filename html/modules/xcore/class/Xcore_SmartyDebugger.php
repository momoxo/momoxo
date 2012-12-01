<?php

use XCore\Kernel\Root;

class Xcore_SmartyDebugger extends Xcore_AbstractDebugger
{
	function prepare()
	{
		$GLOBALS['xoopsErrorHandler'] = XoopsErrorHandler::getInstance();
		$GLOBALS['xoopsErrorHandler']->activate(true);
	}
	
	function isDebugRenderSystem()
	{
		$root = Root::getSingleton();
		$user =& $root->mContext->mXoopsUser;
		
		return is_object($user) ? $user->isAdmin(0) : false;
	}
}
