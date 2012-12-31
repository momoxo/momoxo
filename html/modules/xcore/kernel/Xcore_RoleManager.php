<?php

/**
 * @note draft
 */
use XCore\Kernel\Root;

class Xcore_RoleManager
{
	/**
	 * Loads roles of the specific module with $module, and set loaded roles to
	 * the current principal.
	 * @static
	 * @param XoopsModule $module
	 */
	function loadRolesByModule(&$module)
	{
		static $cache;
		
		$root = Root::getSingleton();
		$context =& $root->mContext;
		
		if ($module == null) {
			return;
		}
		
		if (isset($cache[$module->get('mid')])) {
			return;
		}
		
		$groups = is_object($context->mKarimojiUser) ? $context->mKarimojiUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
		
		$handler =& xoops_gethandler('groupperm');
		if ($handler->checkRight('module_read', $module->get('mid'), $groups)) {
			$context->mUser->addRole('Module.' . $module->get('dirname') . '.Visitor');
		}
		
		if (is_object($context->mKarimojiUser) && $handler->checkRight('module_admin', $module->get('mid'), $groups)) {
			$context->mUser->addRole('Module.' . $module->get('dirname') . '.Admin');
		}
		
		$handler =& xoops_getmodulehandler('group_permission', 'xcore');
		$roleArr = $handler->getRolesByModule($module->get('mid'), $groups);
		foreach ($roleArr as $role) {
			$context->mUser->addRole('Module.' . $module->get('dirname') . '.' . $role);
		}
		
		$cache[$module->get('mid')] = true;
	}
	
	/**
	 * Loads roles of the specific module with $mid, and set loaded roles to
	 * the current principal.
	 * @param int $mid
	 */
	function loadRolesByMid($mid)
	{
		$handler =& xoops_gethandler('module');
		$module =& $handler->get($mid);
		
		if (is_object($module)) {
			$this->loadRolesByModule($module);
		}
	}

	/**
	 * Loads roles of the specific module with $dirname, and set loaded roles
	 * to the current principal.
	 * @param string $dirname The dirname of the specific module.
	 * @see loadRolesByMid()
	 */
	function loadRolesByDirname($dirname)
	{
		$handler =& xoops_gethandler('module');
		$module =& $handler->getByDirname($dirname);
		
		if (is_object($module)) {
			$this->loadRolesByModule($module);
		}
	}
}
