<?php

/**
 * @internal
 */
use XCore\Kernel\Root;
use XCore\Kernel\Controller;
use XCore\Kernel\Ref;
use XCore\Kernel\Delegate;

class Xcore_AdminControllerStrategy extends Xcore_AbstractControllerStrategy
{
	var $mStatusFlag = XCORE_CONTROLLER_STATE_ADMIN;
	
	/**
	 * @var Delegate
	 * @param Controller &$controller
	 */
	var $mSetupBlock = null;
	
	/**
	 *  If this array includes current action, getVirtualCurrentModule() returns
	 * the module object that specified by dirname.
	 * 
	 * @access private
	 */
	var $_mSpecialActions = array("Help", "CommentList");

	function __construct(&$controller)
	{
		global $xoopsOption;
		
		parent::__construct($controller);
		
		//
		// TODO We have to develop complated-switching-controller-mechanizm.
		//
		if (!defined("XCORE_DEPENDENCE_RENDERER")) {
			define("XCORE_DEPENDENCE_RENDERER", "Xcore_AdminRenderSystem");
		}
		
		$controller->mRoot->mContext->mBaseRenderSystemName = "Xcore_AdminRenderSystem";

		//
		// Cover the spec of admin.php of the system module, for the compatibility.
		//
		if (isset($_REQUEST['fct']) && $_REQUEST['fct'] == "users") {
			$GLOBALS['xoopsOption']['pagetype'] = "user";
		}		
		
		$this->mSetupBlock =new Delegate();
		$this->mSetupBlock->register('Xcore_AdminControllerStrategy.SetupBlock');
	}

	function _setupFilterChain()
	{
		parent::_setupFilterChain();

		//
		// Auto pre-loading.
		//
		if($this->mController->mRoot->getSiteConfig('Xcore', 'AutoPreload') == 1) {
			$this->mController->_processPreload(XOOPS_ROOT_PATH . "/preload/admin");
		}
	}
	
	function setupModuleContext(&$context, $dirname)
	{
		if ($dirname == null) {
			$dirname = 'xcore';
		}
		
		parent::setupModuleContext($context, $dirname);
	}
	
	function setupBlock()
	{
		$this->mController->_mBlockChain[] =new Xcore_AdminActionSearch();
		$this->mController->_mBlockChain[] =new Xcore_AdminSideMenu();
		
		$this->mSetupBlock->call(new Ref($this->mController));
	}

	function _processPreBlockFilter()
	{
		parent::_processPreBlockFilter();
		$this->mController->_processModulePreload('/admin/preload');
	}

	function &getVirtualCurrentModule()
	{
		static $ret_module;
		if (is_object($ret_module)) {
			return $ret_module;
		}
		
		if ($this->mController->mRoot->mContext->mModule != null) {
			$module =& $this->mController->mRoot->mContext->mKarimojiModule;
			
			if ($module->get('dirname') == "xcore" && isset($_REQUEST['dirname'])) {
				if (in_array(xoops_getrequest('action'), $this->_mSpecialActions)) {
					$handler =& xoops_gethandler('module');
					$t_xoopsModule =& $handler->getByDirname(xoops_getrequest('dirname'));
					$ret_module =& Xcore_Utils::createModule($t_xoopsModule);
				}
			}
			elseif ($module->get('dirname') == "xcore" && xoops_getrequest('action') == 'PreferenceEdit' && isset($_REQUEST['confmod_id'])) {
				$handler =& xoops_gethandler('module');
				$t_xoopsModule =& $handler->get(intval(xoops_getrequest('confmod_id')));
				$ret_module =& Xcore_Utils::createModule($t_xoopsModule);
			}
			
			if (!is_object($ret_module)) {
				$ret_module =& Xcore_Utils::createModule($module);
			}
		}
		
		return $ret_module;
	}

	function &getMainThemeObject()
	{
		$handler =& xoops_getmodulehandler('theme', 'xcore');
		$theme =& $handler->create();
		
		//
		// TODO Load manifesto here.
		//
		$theme->set('dirname', $this->mController->mRoot->mSiteConfig['Xcore']['Theme']);
		$theme->set('render_system', 'Xcore_AdminRenderSystem');
		
		return $theme;
	}
	
	function isEnableCacheFeature()
	{
		return false;
	}
	
	function enableAccess()
	{
		$principal =& $this->mController->mRoot->mContext->mUser;
		
		if (!$principal->mIdentity->isAuthenticated()) {
			return false;
		}
		
		if ($this->mController->mRoot->mContext->mModule != null) {
			$dirname = $this->mController->mRoot->mContext->mKarimojiModule->get('dirname');
			
			if ($dirname == 'xcore') {
				return $principal->isInRole('Site.Administrator');
			} elseif ( defined('_XCORE_ALLOW_ACCESS_FROM_ANY_ADMINS_') ) {
				return $this->mController->mRoot->mContext->mKarimojiUser->isAdmin(0);
			}
			
			return $principal->isInRole("Module.${dirname}.Admin");
		}
		else {
			return $principal->isInRole('Site.Administrator');
		}
		
		return false;
	}
	
	function setupModuleLanguage()
	{
		$root = Root::getSingleton();
		
		$root->mContext->mKarimojiModule->loadInfo($root->mContext->mKarimojiModule->get('dirname'));
		
		if (isset($root->mContext->mKarimojiModule->modinfo['cube_style']) && $root->mContext->mKarimojiModule->modinfo['cube_style'] != false) {
			$root->mLanguageManager->loadModuleMessageCatalog($root->mContext->mKarimojiModule->get('dirname'));
		}
		$root->mLanguageManager->loadModuleAdminMessageCatalog($root->mContext->mKarimojiModule->get('dirname'));
		$root->mLanguageManager->loadModinfoMessageCatalog($root->mContext->mKarimojiModule->get('dirname'));
	}
}
