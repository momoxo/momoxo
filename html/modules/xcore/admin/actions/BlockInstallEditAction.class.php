<?php
/**
 *
 * @package Xcore
 * @version $Id: BlockInstallEditAction.class.php,v 1.3 2008/09/25 15:11:55 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcore/admin/actions//BlockEditAction.class.php";

require_once XOOPS_MODULE_PATH . "/xcore/class/AbstractEditAction.class.php";
require_once XOOPS_MODULE_PATH . "/xcore/admin/forms/BlockInstallEditForm.class.php";

class Xcore_BlockInstallEditAction extends Xcore_BlockEditAction
{
	function _setupActionForm()
	{
		$this->mActionForm =new Xcore_BlockInstallEditForm();
		$this->mActionForm->prepare();
	}
	
	function _isEditable()
	{
		if (is_object($this->mObject)) {
			return ($this->mObject->get('visible') == 0);
		}
		else {
			return false;
		}
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		parent::executeViewInput($controller, $xoopsUser, $render);
		$render->setTemplateName("blockinstall_edit.html");
	}
	
	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=BlockInstallList");
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect("./index.php?action=BlockInstallList", 1, _MD_XCORE_ERROR_DBUPDATE_FAILED);
	}
	
	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=BlockInstallList");
	}
}

?>
