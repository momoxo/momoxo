<?php

/**
 * @brief Module Update function having possibility to extend by module developers.
 * 
 * The precondition is that the specified module has been installed.
 * 
 * @section cupdate The custom-update-installer
 * 
 * Module developers can use their own custom-update-installer in this action.
 * This function uses Xcore_ModulePhasedUpgrader to update moudles. But, this
 * class can't smart update modules correctly & automatically, because the
 * module updat function bases on XOOPS2 JP spec. We have no rules to declare
 * modules strictly.
 * 
 * To solve it, module developers should use the custom-update-installer,
 * because module developers know detail changelog of their module.
 * 
 * @subsection convention Convention
 * 
 * See Xcore_ModuleUpdateAction::_getInstaller().
 * 
 * \li $modversion['xcore_installer']['updater']['class'] = {classname};
 * \li $modversion['xcore_installer']['updater']['namespace'] = {namespace}; (Optional)
 * \li $modversion['xcore_installer']['updater']['filepath'] = {filepath}; (Optional)
 * 
 * You must declare your sub-class of Xcore_ModulePhasedUpgrader as
 * {namespace}_{classname} in {filepath}. You must specify classname. Others
 * are decided by the naming convention without your descriptions. Namespace
 * is ucfirst(dirname). Filepath is "admin/class/{classname}.class.php".
 * 
 * For example, "news" module.
 * 
 * $modversion['xcore_installer']['updater']['class'] = "Updater";
 * 
 * You must declare News_Updater in XOOPS_ROOT_PATH . "/modules/news/admin/class/Updater.class.php".
 * 
 * In the case where you specify the filepath, take care you describe the
 * filepath with absolute path.
 * 
 * @subsection process Install Process
 * 
 * \li Gets a instance of the update installer class through Xcore_ModuleUpdateAction::_getInstaller().
 * \li Sets the current XoopsModule to the instance.
 * \li Builds the target XoopsModule from xoops_version, and sets it to the instance.
 * \li Sets a value indicating whether an administrator hopes the force-mode, to the instance.
 * \li Calls executeUpgrade().
 * 
 * @see Xcore_ModuleUpdateAction::_getInstaller()
 * @see Xcore_ModulePhasedUpgrader
 * @see Xcore_ModuleInstallUtils
 */
use XCore\Kernel\Ref;
use XCore\Kernel\DelegateUtils;
use XCore\Kernel\Delegate;

class Xcore_ModuleUpdateAction extends Xcore_Action
{
	/**
	 * @var Delegate
	 */
	var $mUpdateSuccess = null;
	
	/**
	 * @var Delegate
	 */
	var $mUpdateFail = null;
	
	var $mKarimojiModule = null;
	
	var $mInstaller = null;
	
	function Xcore_ModuleUpdateAction($flag)
	{
		parent::Xcore_Action($flag);
		
		$this->mUpdateSuccess =new Delegate();
		$this->mUpdateSuccess->register('Xcore_ModuleUpdateAction.UpdateSuccess');
		
		$this->mUpdateFail =new Delegate();
		$this->mUpdateFail->register('Xcore_ModuleUpdateAction.UpdateFail');
	}
	
	function prepare(&$controller, &$xoopsUser)
	{
		$dirname = $controller->mRoot->mContext->mRequest->getRequest('dirname');
		
		$handler =& xoops_gethandler('module');
		$this->mKarimojiModule =& $handler->getByDirname($dirname);
		
		if (!is_object($this->mKarimojiModule)) {
			return false;
		}
		
		$this->_setupActionForm();
		
		$this->mInstaller =& $this->_getInstaller();
		
		//
		// Set the current object.
		//
		$this->mInstaller->setCurrentXoopsModule($this->mKarimojiModule);
		
		//
		// Load the manifesto, and set it as the target object.
		//
        $name = $this->mKarimojiModule->get('name');
		$this->mKarimojiModule->loadInfoAsVar($dirname);
		$this->mKarimojiModule->set('name', $name);
		$this->mInstaller->setTargetXoopsModule($this->mKarimojiModule);
		
		return true;
	}

	function _setupActionForm()
	{
		$this->mActionForm =new Xcore_ModuleUpdateForm();
		$this->mActionForm->prepare();
	}

	/**
	 * Creates a instance of the upgrade installer to mInstaller. And returns
	 * it.
	 * 
	 * The precondition is the existence of mKarimojiModule.
	 */
	function &_getInstaller()
	{
		$dirname = $this->mKarimojiModule->get('dirname');
		$installer =& Xcore_ModuleInstallUtils::createUpdater($dirname);
		return $installer;
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
		$this->mInstaller->executeUpgrade();

		return XCORE_FRAME_VIEW_SUCCESS;
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$renderer)
	{
		if (!$this->mInstaller->mLog->hasError()) {
			$this->mUpdateSuccess->call(new Ref($this->mKarimojiModule), new Ref($this->mInstaller->mLog));
			DelegateUtils::call('Xcore.Admin.Event.ModuleUpdate.' . ucfirst($this->mKarimojiModule->get('dirname') . '.Success'), new Ref($this->mKarimojiModule), new Ref($this->mInstaller->mLog));
		}
		else {
			$this->mUpdateFail->call(new Ref($this->mKarimojiModule), new Ref($this->mInstaller->mLog));
			DelegateUtils::call('Xcore.Admin.Event.ModuleUpdate.' . ucfirst($this->mKarimojiModule->get('dirname') . '.Fail'), new Ref($this->mKarimojiModule), new Ref($this->mInstaller->mLog));
		}
		
		$renderer->setTemplateName("module_update_success.html");
		$renderer->setAttribute('module', $this->mKarimojiModule);
		$renderer->setAttribute('log', $this->mInstaller->mLog->mMessages);
		$renderer->setAttribute('currentVersion', round($this->mInstaller->getCurrentVersion() / 100, 2));
		$renderer->setAttribute('targetVersion', round($this->mInstaller->getTargetPhase() / 100, 2));
		$renderer->setAttribute('isPhasedMode', $this->mInstaller->hasUpgradeMethod());
		$renderer->setAttribute('isLatestUpgrade', $this->mInstaller->isLatestUpgrade());
	}

	function executeViewInput(&$controller, &$xoopsUser, &$renderer)
	{
		$renderer->setTemplateName("module_update.html");
		$renderer->setAttribute('module', $this->mKarimojiModule);
		$renderer->setAttribute('actionForm', $this->mActionForm);
		$renderer->setAttribute('currentVersion', round($this->mInstaller->getCurrentVersion() / 100, 2));
		$renderer->setAttribute('targetVersion', round($this->mInstaller->getTargetPhase() / 100, 2));
		$renderer->setAttribute('isPhasedMode', $this->mInstaller->hasUpgradeMethod());
	}
	
	function executeViewCancel(&$controller, &$xoopsUser, &$renderer)
	{
		$controller->executeForward("./index.php?action=ModuleList");
	}
}

