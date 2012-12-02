<?php

/**
 * @internal
 */
use XCore\Kernel\DelegateUtils;

class Xcore_AbstractControllerStrategy
{
	/**
	 * @var Xcore_Controller
	 */
	var $mController = null;

	var $mStatusFlag;

	function Xcore_AbstractControllerStrategy(&$controller)
	{
		$this->mController =& $controller;
	}

	function _setupFilterChain()
	{
		$primaryPreloads = $this->mController->mRoot->getSiteConfig('Xcore.PrimaryPreloads');
		foreach ($primaryPreloads as $className => $classPath) {
			if (file_exists(XOOPS_ROOT_PATH . $classPath)) {
				require_once XOOPS_ROOT_PATH . $classPath;
				if (class_exists($className) && !isset($this->_mLoadedFilterNames[$className])) {
					$this->_mLoadedFilterNames[$className] = true;
					$filter = new $className($this->mController);
					$this->mController->addActionFilter($filter);
					unset($filter);
				}
			}
		}

		//
		// Auto pre-loading.
		//
		if($this->mController->mRoot->getSiteConfig('Xcore', 'AutoPreload') == 1) {
			$this->mController->_processPreload(XOOPS_ROOT_PATH . '/preload');
		}
	}

	/**
	 * Create some instances for the module process.
	 * Because Xcore_ModuleContext needs XoopsModule instance, this function
	 * kills the process if XoopsModule instance can't be found. Plus, in the
	 * case, raises 'Xcore.Event.Exception.XoopsModuleNotFound'.
	 *
	 * @param Xcore_HttpContext $context
	 * @param string $dirname
	 */
	function setupModuleContext(&$context, $dirname)
	{
		$handler = xoops_gethandler('module');
		$module =& $handler->getByDirname($dirname);

		if (!is_object($module)) {
			DelegateUtils::call('Xcore.Event.Exception.XoopsModuleNotFound', $dirname);
			$this->mController->executeRedirect(XOOPS_URL . '/', 1, 'You can\'t access this URL.');	// TODO need message catalog.
			die(); // need to response?
		}

		$context->mModule =& Xcore_Utils::createModule($module);
		$context->mXoopsModule =& $context->mModule->getXoopsModule();
		$context->mModuleConfig = $context->mModule->getModuleConfig();

		//
		// Load Roles
		//
		$this->mController->mRoot->mRoleManager->loadRolesByMid($context->mXoopsModule->get('mid'));
	}

	function setupBlock()
	{
	}

	function _processPreBlockFilter()
	{
		$this->mController->_processModulePreload('/preload');
	}

	/**
	 * @return XoopsModule
	 * @see Xcore_Controller::getVirtualCurrentModule()
	 */
	function &getVirtualCurrentModule()
	{
		$ret = null;
		return $ret;
	}

	/**
	 * Gets a value indicating whether the controller can use a cache mechanism.
	 */
	function isEnableCacheFeature()
	{
	}

	/**
	 * Gets a value indicating whether the current user can access to the current module.
	 * @return bool
	 */
	function enableAccess()
	{
	}

	function setupModuleLanguage()
	{
	}
}
