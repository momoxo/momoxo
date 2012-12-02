<?php

/**
 * @brief Module Uninstall function having possibility to extend by module developers.
 * 
 * The precondition is that the specified module has been installed && none-actived.
 * 
 * @section cuninstall The custom-uninstaller
 * 
 * Module developers can use their own custom-uninstaller in this action.
 * Unlike the module update function, the standard uninstaller in this action
 * is perhaps no problems. But, duplicatable modules or some modules with the
 * special framework may need the custom-uninstaller.
 * 
 * @subsection convention Convention
 * 
 * See Xcore_ModuleUninstallAction::_getInstaller().
 * 
 * \li $modversion['xcore_installer']['uninstaller']['class'] = {classname};
 * \li $modversion['xcore_installer']['uninstaller']['namespace'] = {namespace}; (Optional)
 * \li $modversion['xcore_installer']['uninstaller']['filepath'] = {filepath}; (Optional)
 * 
 * You must declare your sub-class of Xcore_ModuleUninstaller as
 * {namespace}_{classname} in {filepath}. You must specify classname. Others
 * are decided by the naming convention without your descriptions. Namespace
 * is ucfirst(dirname). Filepath is "admin/class/{classname}.class.php".
 * 
 * For example, "news" module.
 * 
 * $modversion['xcore_installer']['uninstaller']['class'] = "Uninstaller";
 * 
 * You must declare News_Uninstaller in XOOPS_ROOT_PATH . "/modules/news/admin/class/Uninstallerr.class.php".
 * 
 * In the case where you specify the filepath, take care you describe the
 * filepath with absolute path.
 * 
 * @subsection process Uninstall Process
 * 
 * \li Gets a instance of the uninstaller class through Xcore_ModuleUninstallAction::_getInstaller().
 * \li Sets the current XoopsModule to the instance.
 * \li Sets a value indicating whether an administrator hopes the force-mode, to the instance.
 * \li Calls executeUninstall().
 * 
 * @see Xcore_ModuleUninstallAction::_getInstaller()
 * @see Xcore_ModuleUninstaller
 * @see Xcore_ModuleInstallUtils
 * 
 * @todo These classes are good to abstract again.
 */
use XCore\Kernel\Ref;

class Xcore_ModuleUninstallAction extends Xcore_Action
{
	/**
	 * @private
	 * @var XCube_Delegate
	 */
	var $mUninstallSuccess = null;
	
	/**
	 * @private
	 * @var XCube_Delegate
	 */
	var $mUninstallFail = null;
	
	/**
	 * @private
	 * @var XoopsModule
	 */
	var $mXoopsModule = null;
	
	/**
	 * @private
	 * @var Xcore_ModuleUinstaller
	 */
	var $mInstaller = null;
	
	function Xcore_ModuleUninstallAction($flag)
	{
		parent::Xcore_Action($flag);
		
		$this->mUninstallSuccess =new XCube_Delegate();
		$this->mUninstallSuccess->register('Xcore_ModuleUninstallAction.UninstallSuccess');
		
		$this->mUninstallFail =new XCube_Delegate();
		$this->mUninstallFail->register('Xcore_ModuleUninstallAction.UninstallFail');
	}

	function prepare(&$controller, &$xoopsUser)
	{
		$dirname = $controller->mRoot->mContext->mRequest->getRequest('dirname');
		
		$handler =& xoops_gethandler('module');
		$this->mXoopsModule =& $handler->getByDirname($dirname);



		if (!(is_object($this->mXoopsModule) && $this->mXoopsModule->get('isactive') == 0)) {
			return false;
		}
		$this->mXoopsModule->loadInfoAsVar($dirname);

		$this->_setupActionForm();
		
		$this->mInstaller =& $this->_getInstaller();
		
		//
		// Set the current object.
		//
		$this->mInstaller->setCurrentXoopsModule($this->mXoopsModule);
		return true;
	}
	
	function &_getInstaller()
	{
		$dirname = $this->mXoopsModule->get('dirname');
		$installer =&  Xcore_ModuleInstallUtils::createUninstaller($dirname);
		return $installer;
	}
	
	function _setupActionForm()
	{
		$this->mActionForm =new Xcore_ModuleUninstallForm();
		$this->mActionForm->prepare();
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		$this->mActionForm->load($this->mXoopsModule);
		
		return XCORE_FRAME_VIEW_INPUT;
	}

	function execute(&$controller, &$xoopsUser)
	{
		if (isset($_REQUEST['_form_control_cancel'])) {
			return XCORE_FRAME_VIEW_CANCEL;
		}
		
		$this->mActionForm->fetch();
		$this->mActionForm->validate();
		
		if ($this->mActionForm->hasError()) {
			return $this->getDefaultView($controller, $xoopsUser);
		}
		
		$this->mInstaller->setForceMode($this->mActionForm->get('force'));
		$this->mInstaller->executeUninstall();

		return XCORE_FRAME_VIEW_SUCCESS;
	}
	
	function executeViewSuccess(&$controller, &$xoopsUser, &$renderer)
	{
		if (!$this->mInstaller->mLog->hasError()) {
			$this->mUninstallSuccess->call(new Ref($this->mXoopsModule), new Ref($this->mInstaller->mLog));
			XCube_DelegateUtils::call('Xcore.Admin.Event.ModuleUninstall.' . ucfirst($this->mXoopsModule->get('dirname') . '.Success'), new Ref($this->mXoopsModule), new Ref($this->mInstaller->mLog));
		}
		else {
			$this->mUninstallFail->call(new Ref($this->mXoopsModule), new Ref($this->mInstaller->mLog));
			XCube_DelegateUtils::call('Xcore.Admin.Event.ModuleUninstall.' . ucfirst($this->mXoopsModule->get('dirname') . '.Fail'), new Ref($this->mXoopsModule), new Ref($this->mInstaller->mLog));
		}

		$renderer->setTemplateName("module_uninstall_success.html");
		$renderer->setAttribute('module',$this->mXoopsModule);
		$renderer->setAttribute('log', $this->mInstaller->mLog->mMessages);
	}

	function executeViewInput(&$controller, &$xoopsUser, &$renderer)
	{
		$renderer->setTemplateName("module_uninstall.html");
		$renderer->setAttribute('actionForm', $this->mActionForm);
		$renderer->setAttribute('module', $this->mXoopsModule);
		$renderer->setAttribute('currentVersion', round($this->mXoopsModule->get('version') / 100, 2));
	}

	function executeViewCancel(&$controller, &$xoopsUser, &$renderer)
	{
		$controller->executeForward("./index.php?action=ModuleList");
	}
}

