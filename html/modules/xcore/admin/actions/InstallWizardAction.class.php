<?php

/***
 * @internal
 * @public
 * Install module
 */
class Xcore_InstallWizardAction extends Xcore_AbstractModuleInstallAction
{
	var $mLicence;
	var $mLicenceText;

	function &_getInstaller($dirname)
	{
		$installer =new Xcore_ModuleInstaller($dirname);
		return $installer;
	}
	
	function _setupActionForm()
	{
		$this->mActionForm =new Xcore_InstallWizardForm();
		$this->mActionForm->prepare();
	}

	function _loadAgreement()
	{
		$root =& XCube_Root::getSingleton();
		
		$this->mLicence = $this->mModuleObject->modinfo['installer']['licence']['title'];

		$file = $this->mModuleObject->modinfo['installer']['licence']['file'];
		$language = $root->mContext->getXoopsConfig('language');

		//
		// TODO Replace with language manager.
		//
		$path = XOOPS_MODULE_PATH . "/" . $this->mModuleObject->get('dirname') ."/language/" . $language . "/" . $file;
		if (!file_exists($path)) {
			$path = XOOPS_MODULE_PATH . "/" . $this->mModuleObject->get('dirname') . "/language/english/" . $file;
			if (!file_exists($path)) {
				return;
			}
		}

		$this->mLicenceText = file_get_contents($path);
	}
	
	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("module_install_success.html");
		$render->setAttribute('log', $this->mLog->mMessages);
	}

	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		$render->setAttribute('module', $this->mModuleObject);
		$render->setAttribute('actionForm', $this->mActionForm);

		if (isset($this->mModuleObject->modinfo['installer'])) {
			$render->setAttribute('image', $this->mModuleObject->modinfo['installer']['image']);
			$render->setAttribute('description', $this->mModuleObject->modinfo['installer']['description']);
			$render->setTemplateName("install_wizard.html");
		}
		else {
			$controller->executeForward("index.php?action=ModuleInstall&dirname=" . $this->mModuleObject->get('dirname'));
		}
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("install_wizard_licence.html");
		$render->setAttribute('module', $this->mModuleObject);
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('licence', $this->mLicence);
		$render->setAttribute('licenceText', $this->mLicenceText);
	}
}

