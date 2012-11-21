<?php

define('XCORE_ADMINMENU_CACHEPREFIX', XOOPS_CACHE_PATH.'/'.urlencode(XOOPS_URL).'_admin_menu_');

/**
 * This is test menu block for control panel of Legacy module.
 * This loads module objects by a permission of the current user.
 * Then this load module's adminmenu and module's information.
 *
 * [ASSIGN]
 *	Array of module objects.
 * 
 * @package xcore
 */
class Xcore_AdminSideMenu extends Xcore_AbstractBlockProcedure
{
	var $mModules = array();
	
	/**
	 * protected, but read OK.
	 * 
	 * @access protected
	 */
	var $mCurrentModule = null;

	function getName()
	{
		return "sidemenu";
	}

	function getTitle()
	{
		return "TEST: AdminSideMenu";
	}
	
	function getEntryIndex()
	{
		return 0;
	}

	function isEnableCache()
	{
		return false;
	}

	function execute()
	{
		$root =& XCube_Root::getSingleton();
		
		// load message catalog of Legacy for _AD_XCORE_LANG_NO_SETTING, even if the current module is not Xcore.
		$langMgr =& $root->mLanguageManager;
		$langMgr->loadModuleAdminMessageCatalog('xcore');
		//
		$langMgr->loadModinfoMessageCatalog('xcore');
		
		$controller =& $root->mController;
		$user =& $root->mContext->mXoopsUser;
		$groups = implode(",", $user->getGroups());
		$cachePath = XCORE_ADMINMENU_CACHEPREFIX . md5(XOOPS_SALT . "($groups)". $langMgr->mLanguageName).'.html';
		$render =& $this->getRenderTarget();
		if (file_exists($cachePath)) {
			$render->mRenderBuffer = file_get_contents($cachePath);
			return;
		}
		$render->setAttribute('xcore_module', 'xcore');
		
		$this->mCurrentModule =& $controller->mRoot->mContext->mXoopsModule;
		
		if ($this->mCurrentModule->get('dirname') == 'xcore') {
			if (xoops_getrequest('action') == "help") {
				$moduleHandler =& xoops_gethandler('module');
				$t_module =& $moduleHandler->getByDirname(xoops_gethandler('dirname'));
				if (is_object($t_module)) {
					$this->mCurrentModule =& $t_module;
				}
			}
		}
		
		$db=&$controller->getDB();

		$mod = $db->prefix("modules");
		$perm = $db->prefix("group_permission");
		
		//
		// Users who are belong to ADMIN GROUP have every permissions, so we have to prepare two kinds of SQL.
		//
		if ($root->mContext->mUser->isInRole('Site.Owner')) {
			$sql = "SELECT DISTINCT mid FROM ${mod} WHERE isactive=1 AND hasadmin=1 ORDER BY weight, mid";
		}
		else {
			$sql = "SELECT DISTINCT ${mod}.mid FROM ${mod},${perm} " .
				   "WHERE ${mod}.isactive=1 AND ${mod}.mid=${perm}.gperm_itemid AND ${perm}.gperm_name='module_admin' AND ${perm}.gperm_groupid IN (${groups}) " .
				   "AND ${mod}.hasadmin=1 " .
				   "ORDER BY ${mod}.weight, ${mod}.mid";
		}


		$result=$db->query($sql);
		
		$handler =& xoops_gethandler('module');
		
		while(list($mid) = $db->fetchRow($result)) {
			$xoopsModule = & $handler->get($mid);
			$module =& Xcore_Utils::createModule($xoopsModule, false);

			$this->mModules[] =& $module;
			unset($module);
		}
		//
		$tpl = $db->prefix("tplfile");
		$tpl_modules = array();
		$sql = "SELECT DISTINCT tpl_module FROM ${tpl}";
		$result = $db->query($sql);
		while($row = $db->fetchArray($result)) {
			$tpl_modules[] = $row['tpl_module'];
		}
		$render->setAttribute('tplmodules', $tpl_modules);
		//

		$render->setTemplateName('xcore_admin_block_sidemenu.html');
		$render->setAttribute('modules', $this->mModules);
		$render->setAttribute('currentModule', $this->mCurrentModule);
		
		$renderSystem =& $root->getRenderSystem($this->getRenderSystemName());
		
		$renderSystem->renderBlock($render);
		file_put_contents($cachePath, $render->mRenderBuffer);
	}

	static function clearCache()
	{
		$adminMenucache = glob(XCORE_ADMINMENU_CACHEPREFIX . '*.html');
		if ($adminMenucache) {
			foreach ($adminMenucache as $file) {
				unlink($file);
			}
		}
	}
}

?>