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
use XCore\Kernel\Ref;
use XCore\Kernel\DelegateUtils;
use XCore\Kernel\Delegate;

class Xcore_ModuleInstallAction extends Xcore_Action
{
	/**
	 * @var Delegate
	 */
	var $mInstallSuccess = null;
	
	/**
	 * @var Delegate
	 */
	var $mInstallFail = null;
	
	/**
	 * @private
	 * @var XoopsModule
	 */
	var $mKarimojiModule = null;
	
	/**
	 * @private
	 * @var Xcore_ModuleUinstaller
	 */
	var $mInstaller = null;
	
	function Xcore_ModuleInstallAction($flag)
	{
		parent::Xcore_Action($flag);
		
		$this->mInstallSuccess =new Delegate();
		$this->mInstallSuccess->register('Xcore_ModuleInstallAction.InstallSuccess');
		
		$this->mInstallFail =new Delegate();
		$this->mInstallFail->register('Xcore_ModuleInstallAction.InstallFail');
	}
	
	function prepare(&$controller, &$xoopsUser)
	{
		$dirname = $controller->mRoot->mContext->mRequest->getRequest('dirname');
		
		$handler =& xoops_gethandler('module');
		$this->mKarimojiModule =& $handler->getByDirname($dirname);
		
		if (is_object($this->mKarimojiModule)) {
			return false;
		}
		
        $this->mKarimojiModule =& $handler->create();
        
        $this->mKarimojiModule->loadInfoAsVar($dirname);
        $this->mKarimojiModule->set('weight', 1);
        
        if ($this->mKarimojiModule->get('dirname') == null) {
            return false;
        }
        
        if ($this->mKarimojiModule->get('dirname') == 'system') {
            $this->mKarimojiModule->set('mid', 1);
        }
		
		$this->_setupActionForm();
		
		$this->mInstaller =& $this->_getInstaller();
		
		//
		// Set the current object.
		//
		$this->mInstaller->setCurrentXoopsModule($this->mKarimojiModule);
		
		return true;
	}

	function &_getInstaller()
	{
		$dirname = $this->mKarimojiModule->get('dirname');
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
		$this->mActionForm->load($this->mKarimojiModule);
		
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
			$dirname = $this->mKarimojiModule->get('dirname');
			$uninstaller =& Xcore_ModuleInstallUtils::createUninstaller($dirname);
			
			$uninstaller->setForceMode(true);
			$uninstaller->setCurrentXoopsModule($this->mKarimojiModule);
			
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
			$this->mInstallSuccess->call(new Ref($this->mKarimojiModule), new Ref($this->mInstaller->mLog));
			DelegateUtils::call('Xcore.Admin.Event.ModuleInstall.' . ucfirst($this->mKarimojiModule->get('dirname') . '.Success'), new Ref($this->mKarimojiModule), new Ref($this->mInstaller->mLog));
		}
		else {
			$this->mInstallFail->call(new Ref($this->mKarimojiModule), new Ref($this->mInstaller->mLog));
			DelegateUtils::call('Xcore.Admin.Event.ModuleInstall.' . ucfirst($this->mKarimojiModule->get('dirname') . '.Fail'), new Ref($this->mKarimojiModule), new Ref($this->mInstaller->mLog));
		}

		$renderer->setTemplateName("module_install_success.html");
		$renderer->setAttribute('module', $this->mKarimojiModule);
		$renderer->setAttribute('log', $this->mInstaller->mLog->mMessages);
	}

	/**
	 * @todo no $renderer. It should be $render.
	 */
	function executeViewInput(&$controller,&$xoopsUser,&$renderer)
	{
		$renderer->setTemplateName("module_install.html");
		$renderer->setAttribute('module', $this->mKarimojiModule);
		$renderer->setAttribute('actionForm', $this->mActionForm);
		$renderer->setAttribute('currentVersion', round($this->mKarimojiModule->get('version') / 100, 2));
	}

	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=InstallList");
	}
}

