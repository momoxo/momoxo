<?php

class XcoreModuletplObject extends XoopsSimpleObject
{
	function XcoreModuletplObject()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->mVars = $initVars;
			return;
		}
		$this->initVar('mid', XOBJ_DTYPE_INT, '', true);
		$this->initVar('name', XOBJ_DTYPE_STRING, '', true, 150);
		$this->initVar('dirname', XOBJ_DTYPE_STRING, '', true, 150);
		$this->initVar('count', XOBJ_DTYPE_INT, 0, true);
		$initVars=$this->mVars;
	}
}

class XcoreTplsetObject extends XoopsSimpleObject
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

class XcoreTplsetHandler extends XoopsObjectGenericHandler
{
	var $mTable = "tplset";
	var $mPrimary = "tplset_id";
	var $mClass = "XcoreTplsetObject";
	
	function insertClone($original, $clone)
	{
		if (!$this->insert($clone)) {
			return false;
		}
		
		//
		// fetch all tplfile object and do cloning.
		//
		$handler =& xoops_getmodulehandler('tplfile', 'xcore');
		
		$files =& $handler->getObjects(new Criteria('tpl_tplset', $original->get('tplset_name')));
		foreach ($files as $file) {
			$cloneFile =& $file->createClone($clone->get('tplset_name'));
			$handler->insert($cloneFile);
		}
		
		return true;	///< TODO
	}

	function delete(&$obj, $force)
	{
		$handler =& xoops_getmodulehandler('tplfile', 'xcore');
		$handler->deleteAll(new Criteria('tpl_tplset', $obj->get('tplset_name')));

		return parent::delete($obj, $force);
	}
}

