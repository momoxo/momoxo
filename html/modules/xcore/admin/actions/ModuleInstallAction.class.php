<?php

/**
 * 
 * @brief Module Install function having possibility to extend by module developers.
 * 
 * The precondition is that the specified module has been not installed.
 * 
 * @section cinstall The custom-installer
 * 
 * Module developers can use their own custom-installer in this action. Unlike
 * the module update function, the standard installer in this action is perhaps
 * no problems. But, duplicatable modules or some modules with the special
 * framework may need the custom-installer.
 * 
 * @subsection convention Convention
 * 
 * See Xcore_ModuleInstallAction::_getInstaller().
 * 
 * \li $modversion['xcore_installer']['installer']['class'] = {classname};
 * \li $modversion['xcore_installer']['installer']['namespace'] = {namespace}; (Optional)
 * \li $modversion['xcore_installer']['installer']['filepath'] = {filepath}; (Optional)
 * 
 * You must declare your sub-class of Xcore_ModuleInstaller as
 * {namespace}_{classname} in {filepath}. You must specify classname. Others
 * are decided by the naming convention without your descriptions. Namespace
 * is ucfirst(dirname). Filepath is "admin/class/{classname}.class.php".
 * 
 * For example, "news" module.
 * 
 * $modversion['xcore_installer']['installer']['class'] = "Installer";
 * 
 * You must declare News_Installer in XOOPS_ROOT_PATH . "/modules/news/admin/class/Installerr.class.php".
 * 
 * In the case where you specify the filepath, take care you describe the
 * filepath with absolute path.
 * 
 * @subsection process Install Process
 * 
 * \li Gets a instance of the installer class through Xcore_ModuleInstallAction::_getInstaller().
 * \li Sets the new XoopsModule built from xoops_version, to the instance.
 * \li Sets a value indicating whether an administrator hopes the force-mode, to the instance.
 * \li Calls executeInstall().
 * 
 * @see Xcore_ModuleInstallAction::_getInstaller()
 * @see Xcore_ModuleInstaller
 * @see Xcore_ModuleInstallUtils
 * 
 * @todo These classes are good to abstract again.
 */
class Xcore_ModuleInstallAction extends Xcore_Action
{
	/**
	 * @var XCube_Delegate
	 */
	var $mInstallSuccess = null;
	
	/**
	 * @var XCube_Delegate
	 */
	var $mInstallFail = null;
	
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
	
	function Xcore_ModuleInstallAction($flag)
	{
		parent::Xcore_Action($flag);
		
		$this->mInstallSuccess =new XCube_Delegate();
		$this->mInstallSuccess->register('Xcore_ModuleInstallAction.InstallSuccess');
		
		$this->mInstallFail =new XCube_Delegate();
		$this->mInstallFail->register('Xcore_ModuleInstallAction.InstallFail');
	}
	
	function prepare(&$controller, &$xoopsUser)
	{
		$dirname = $controller->mRoot->mContext->mRequest->getRequest('dirname');
		
		$handler =& xoops_gethandler('module');
		$this->mXoopsModule =& $handler->getByDirname($dirname);
		
		if (is_object($this->mXoopsModule)) {
			return false;
		}
		
        $this->mXoopsModule =& $handler->create();
        
        $this->mXoopsModule->set('weight', 1);
        $this->mXoopsModule->loadInfoAsVar($dirname);
        
        if ($this->mXoopsModule->get('dirname') == null) {
            return false;
        }
        
        if ($this->mXoopsModule->get('dirname') == 'system') {
            $this->mXoopsModule->set('mid', 1);
        }
		
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
		$installer =& Xcore_ModuleInstallUtils::createInstaller($dirname);
		return $installer;
	}
		
	function _setupActionForm()
	{
		$this->mActionForm =new Xcore_ModuleInstallForm();
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
		if (!$this->mInstaller->executeInstall()) {
			$this->mInstaller->mLog->addReport('Force Uninstallation is started.');
			$dirname = $this->mXoopsModule->get('dirname');
			$uninstaller =& Xcore_ModuleInstallUtils::createUninstaller($dirname);
			
			$uninstaller->setForceMode(true);
			$uninstaller->setCurrentXoopsModule($this->mXoopsModule);
			
			$uninstaller->executeUninstall();
		}

		return XCORE_FRAME_VIEW_SUCCESS;
	}
	
	/**
	 * @todo no $renderer. It should be $render.
	 */
	function executeViewSuccess(&$controller,&$xoopsUser,&$renderer)
	{
		if (!$this->mInstaller->mLog->hasError()) {
			$this->mInstallSuccess->call(new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
			XCube_DelegateUtils::call('Xcore.Admin.Event.ModuleInstall.' . ucfirst($this->mXoopsModule->get('dirname') . '.Success'), new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
		}
		else {
			$this->mInstallFail->call(new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
			XCube_DelegateUtils::call('Xcore.Admin.Event.ModuleInstall.' . ucfirst($this->mXoopsModule->get('dirname') . '.Fail'), new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
		}

		$renderer->setTemplateName("module_install_success.html");
		$renderer->setAttribute('module', $this->mXoopsModule);
		$renderer->setAttribute('log', $this->mInstaller->mLog->mMessages);
	}

	/**
	 * @todo no $renderer. It should be $render.
	 */
	function executeViewInput(&$controller,&$xoopsUser,&$renderer)
	{
		$renderer->setTemplateName("module_install.html");
		$renderer->setAttribute('module', $this->mXoopsModule);
		$renderer->setAttribute('actionForm', $this->mActionForm);
		$renderer->setAttribute('currentVersion', round($this->mXoopsModule->get('version') / 100, 2));
	}

	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=InstallList");
	}
}

?>
