<?php
/**
 * @package xcoreRender
 * @version $Id: BannerclientEditAction.class.php,v 1.1 2007/05/15 02:34:17 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcoreRender/class/AbstractEditAction.class.php";
require_once XOOPS_MODULE_PATH . "/xcoreRender/admin/forms/BannerclientAdminEditForm.class.php";

class XcoreRender_BannerclientEditAction extends XcoreRender_AbstractEditAction
{
	function _getId()
	{
		return xoops_getrequest('cid');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('bannerclient');
		return $handler;
	}

	function _setupActionForm()
	{
		$this->mActionForm =new XcoreRender_BannerclientAdminEditForm();
		$this->mActionForm->prepare();
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("bannerclient_edit.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		$this->mObject->loadBanner();
		$this->mObject->loadBannerfinish();
		$render->setAttribute('object', $this->mObject);
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=BannerclientList");
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect("./index.php?action=BannerclientList", 1, _AD_XCORERENDER_ERROR_DBUPDATE_FAILED);
	}

	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=BannerclientList");
	}
}

?>
