<?php

/***
 * @internal
 * @public
 * @todo This action should be implemented by base. We must move it to user.
 */
use XCore\Utils\Utils;

class Xcore_MiscSslloginAction extends Xcore_Action
{
	function execute(&$controller, &$xoopsUser)
	{
		return XCORE_FRAME_VIEW_INDEX;
	}
	
	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		//
		// Because this action's template uses USER message catalog, load it.
		//
		$root =& $controller->mRoot;
	
		$config_handler =& xoops_gethandler('config');
		$moduleConfigUser =& $config_handler->getConfigsByDirname('user');
	
		if($moduleConfigUser['use_ssl'] == 1 && ! empty($_POST[$moduleConfigUser['sslpost_name']])){
			session_id($_POST[$moduleConfigUser['sslpost_name']]);
		}
	
		$render->setTemplateName("xcore_misc_ssllogin.html");
		$render->setAttribute("message", Utils::formatMessage(_MD_XCORE_MESSAGE_LOGIN_SUCCESS, $xoopsUser->get('uname')));
	}
}

