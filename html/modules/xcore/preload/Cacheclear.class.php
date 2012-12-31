<?php

/***
 * @internal
 * @todo
 *    This may have to be admin-preload.
 */
use XCore\Kernel\ActionFilter;
use XCore\Database\Criteria;

class Xcore_Cacheclear extends ActionFilter {
    function preBlockFilter()
    {
		$this->mRoot->mDelegateManager->add('Xcore_ModuleInstallAction.InstallSuccess', 'Xcore_Cacheclear::cacheClear');
		$this->mRoot->mDelegateManager->add('Xcore_ModuleUpdateAction.UpdateSuccess', 'Xcore_Cacheclear::cacheClear');
		$this->mRoot->mDelegateManager->add('Xcore_ModuleUninstaller._fireNotifyUninstallTemplateBegun', 'Xcore_Cacheclear::cacheClear');
    }
    
    function cacheClear(&$module)
	{
		$handler =& xoops_getmodulehandler('tplfile', 'xcore');
		
		$criteria =new Criteria('tpl_module', $module->get('dirname'));
		$tplfileArr = $handler->getObjects($criteria);
		
		$xoopsTpl =new XoopsTpl();
		foreach (array_keys($tplfileArr) as $key) {
			$xoopsTpl->clear_cache('db:' . $tplfileArr[$key]->get('tpl_file'));
			$xoopsTpl->clear_compiled_tpl('db:' . $tplfileArr[$key]->get('tpl_file'));
		}
    }
}
