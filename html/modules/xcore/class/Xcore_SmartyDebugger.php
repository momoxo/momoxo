<?php

class Xcore_SmartyDebugger extends Xcore_AbstractDebugger
{
	function prepare()
	{
		$GLOBALS['xoopsErrorHandler'] =& XoopsErrorHandler::getInstance();
		$GLOBALS['xoopsErrorHandler']->activate(true);
	}
	
	function isDebugRenderSystem()
	{
		$root =& XCube_Root::getSingleton();
		$user =& $root->mContext->mXoopsUser;
		
		return is_object($user) ? $user->isAdmin(0) : false;
	}
}
