<?php
/**
 *
 * @package Xcore
 * @version $Id: NotifyDeleteAction.class.php,v 1.4 2008/09/25 15:12:11 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/modules/xcore/include/notification_functions.php";

require_once XOOPS_MODULE_PATH . "/xcore/forms/NotifyDeleteForm.class.php";

/***
 * @internal
 * List up notifications. This action is like notifications.php (when $op is
 * 'list').
 */
class Xcore_NotifyDeleteAction extends Xcore_Action
{
	var $mModules = array();
	var $mActionForm = null;
	
	var $mErrorMessage = null;
	
	function prepare(&$controller, &$xoopsUser)
	{
		$controller->mRoot->mLanguageManager->loadPageTypeMessageCatalog('notification');
		$controller->mRoot->mLanguageManager->loadModuleMessageCatalog('xcore');
		
		$this->mActionForm =new Xcore_NotifyDeleteForm();
		$this->mActionForm->prepare();
	}

	function hasPermission(&$controller, &$xoopsUser)
	{
		return is_object($xoopsUser);
	}

	/**
	 * This member function is a special case. Because the confirm is must, it
	 * uses token error for displaying confirm.
	 */	
	function execute(&$contoller, &$xoopsUser)
	{
		$this->mActionForm->fetch();
		$this->mActionForm->validate();
		
		//
		// If input values are error, the action form returns fatal error flag.
		// If it's not fatal, display confirm form.
		//
		if ($this->mActionForm->hasError()) {
			return $this->mActionForm->mFatalError ? XCORE_FRAME_VIEW_ERROR : XCORE_FRAME_VIEW_INPUT;
		}

		//
		// Execute deleting.
		//
		$successFlag = true;
		$handler =& xoops_gethandler('notification');
		foreach ($this->mActionForm->mNotifiyIds as $t_idArr) {
			$t_notify =& $handler->get($t_idArr['id']);
			if (is_object($t_notify) && $t_notify->get('not_uid') == $xoopsUser->get('uid') && $t_notify->get('not_modid') == $t_idArr['modid']) {
				$successFlag = $successFlag & $handler->delete($t_notify);
			}
		}
		
		return $successFlag ? XCORE_FRAME_VIEW_SUCCESS : XCORE_FRAME_VIEW_ERROR;
	}
		
	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("xcore_notification_delete.html");
		$render->setAttribute('actionForm', $this->mActionForm);
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward(XOOPS_URL . "/notifications.php");
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect(XOOPS_URL . "/notifications.php", 2, _NOT_NOTHINGTODELETE);
	}
}

?>
