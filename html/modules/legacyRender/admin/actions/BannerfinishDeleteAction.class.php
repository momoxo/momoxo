<?php
/**
 * @package xcoreRender
 * @version $Id: BannerfinishDeleteAction.class.php,v 1.1 2007/05/15 02:34:17 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcoreRender/class/AbstractDeleteAction.class.php";
require_once XOOPS_MODULE_PATH . "/xcoreRender/admin/forms/BannerfinishAdminDeleteForm.class.php";

class XcoreRender_BannerfinishDeleteAction extends XcoreRender_AbstractDeleteAction
{
	function _getId()
	{
		return xoops_getrequest('bid');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('bannerfinish');
		return $handler;
	}

	function _setupActionForm()
	{
		$this->mActionForm =new XcoreRender_BannerfinishAdminDeleteForm();
		$this->mActionForm->prepare();
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("bannerfinish_delete.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		$this->mObject->loadBannerclient();
		$render->setAttribute('object', $this->mObject);
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=BannerfinishList");
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect("./index.php?action=BannerfinishList", 1, _AD_XCORERENDER_ERROR_DBUPDATE_FAILED);
	}
	
	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=BannerfinishList");
	}
}

?>
