<?php
/**
 *
 * @package Xcore
 * @version $Id: ModuleUpdateAction.class.php,v 1.3 2008/09/25 15:11:54 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

if ($actionName === 'ModuleInstall') {
class Xupdate_ModuleInstallAction extends Xcore_ModuleInstallAction
{
	function executeViewSuccess(&$controller, &$xoopsUser, &$renderer)
	{
		if (!$this->mInstaller->mLog->hasError()) {
			XCube_DelegateUtils::call('Xcore.Admin.Event.ModuleInstall.Success', new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
		} else {
			XCube_DelegateUtils::call('Xcore.Admin.Event.ModuleInstall.Fail', new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
		}

		parent::executeViewSuccess($controller, $xoopsUser, $renderer);
	}
}
}

if ($actionName === 'ModuleUpdate') {
class Xupdate_ModuleUpdateAction extends Xcore_ModuleUpdateAction
{
	function executeViewSuccess(&$controller, &$xoopsUser, &$renderer)
	{
		if (!$this->mInstaller->mLog->hasError()) {
			XCube_DelegateUtils::call('Xcore.Admin.Event.ModuleUpdate.Success', new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
		} else {
			XCube_DelegateUtils::call('Xcore.Admin.Event.ModuleUpdate.Fail', new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
		}
		
		parent::executeViewSuccess($controller, $xoopsUser, $renderer);
	}
}
}

if ($actionName === 'ModuleUninstall') {
class Xupdate_ModuleUninstallAction extends Xcore_ModuleUninstallAction
{
	function executeViewSuccess(&$controller, &$xoopsUser, &$renderer)
	{
		if (!$this->mInstaller->mLog->hasError()) {
			XCube_DelegateUtils::call('Xcore.Admin.Event.ModuleUninstall.Success', new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
		} else {
			XCube_DelegateUtils::call('Xcore.Admin.Event.ModuleUninstall.Fail', new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
		}

		parent::executeViewSuccess($controller, $xoopsUser, $renderer);
	}
}
}

if ($actionName === 'ModuleList') {
class Xupdate_ModuleListAction extends Xcore_ModuleListAction
{
	function execute(&$controller, &$xoopsUser)
	{
		$ret = parent::execute($controller, $xoopsUser);
		if ($ret === XCORE_FRAME_VIEW_SUCCESS) {
			XCube_DelegateUtils::call('Xcore.Admin.Event.ModuleListSave.Success', new XCube_Ref($this->mActionForm));
		} else if ($ret === XCORE_FRAME_VIEW_ERROR) {
			XCube_DelegateUtils::call('Xcore.Admin.Event.ModuleListSave.Fail', new XCube_Ref($this->mActionForm));
		}
		return $ret;
	}
}
}