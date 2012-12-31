<?php

use XCore\Database\CriteriaCompo;
use XCore\Entity\SimpleObject;
use XCore\Database\Criteria;

class XcoreTplsetObject extends SimpleObject
{
	var $mModuleTemplates = array();
	
	function XcoreTplsetObject()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->mVars = $initVars;
			return;
		}
		$this->initVar('tplset_id', XOBJ_DTYPE_INT, '', true);
		$this->initVar('tplset_name', XOBJ_DTYPE_STRING, '', true, 50);
		$this->initVar('tplset_desc', XOBJ_DTYPE_STRING, '', true, 255);
		$this->initVar('tplset_credits', XOBJ_DTYPE_TEXT, '', true);
		$this->initVar('tplset_created', XOBJ_DTYPE_INT, time(), true);
		$initVars=$this->mVars;
	}
	
	function loadModuletpl()
	{
		//
		// get module list
		//
		$moduleHandler =& xoops_gethandler('module');
		$modules =& $moduleHandler->getObjects();
		
		$tplfileHandler =& xoops_getmodulehandler('tplfile', 'xcore');
		
		foreach ($modules as $module) {
			$modtpl =new XcoreModuletplObject();
			
			$modtpl->set('mid', $module->get('mid'));
			$modtpl->set('dirname', $module->get('dirname'));
			$modtpl->set('name', $module->get('name'));
			
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('tpl_module', $module->get('dirname')));
			$criteria->add(new Criteria('tpl_tplset', $this->get('tplset_name')));
			
			$count = $tplfileHandler->getCount($criteria);
			$modtpl->set('count', $count);
			
			$this->mModuleTemplates[] =& $modtpl;
			unset($modtpl);
		}
	}
}
