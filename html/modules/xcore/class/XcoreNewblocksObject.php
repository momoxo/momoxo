<?php

class XcoreNewblocksObject extends XoopsSimpleObject
{
	var $mModule = null;
	
	/**
	 * Array of group objects who can access this object.
	 * It need lazy loading to access.
	 */
	var $mGroup = array();
	
	var $mBmodule = array();
	
	var $mColumn = null;
	
	var $mCachetime = null;

	function XcoreNewblocksObject()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->mVars = $initVars;
			return;
		}
		$this->initVar('bid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('mid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('func_num', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('options', XOBJ_DTYPE_STRING, '', true, 255);
		$this->initVar('name', XOBJ_DTYPE_STRING, '', true, 150);
		$this->initVar('title', XOBJ_DTYPE_STRING, '', true, 255);
		$this->initVar('content', XOBJ_DTYPE_TEXT, '', true);
		$this->initVar('side', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('weight', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('visible', XOBJ_DTYPE_BOOL, '0', true);
		$this->initVar('block_type', XOBJ_DTYPE_STRING, '', true, 1);
		$this->initVar('c_type', XOBJ_DTYPE_STRING, '', true, 1);
		$this->initVar('isactive', XOBJ_DTYPE_BOOL, '0', true);
		$this->initVar('dirname', XOBJ_DTYPE_STRING, '', true, 50);
		$this->initVar('func_file', XOBJ_DTYPE_STRING, '', true, 50);
		$this->initVar('show_func', XOBJ_DTYPE_STRING, '', true, 50);
		$this->initVar('edit_func', XOBJ_DTYPE_STRING, '', true, 50);
		$this->initVar('template', XOBJ_DTYPE_STRING, '', true, 50);
		$this->initVar('bcachetime', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('last_modified', XOBJ_DTYPE_INT, time(), true);
		$initVars = $this->mVars;
	}
	
	function loadModule()
	{
		$handler =& xoops_gethandler('module');
		$this->mModule =& $handler->get($this->get('mid'));
	}

	/**
	 * Load group objects who can access this object. And, set the objects to mGroup.
	 * 
	 * TODO Need lock double loading.
	 */	
	function loadGroup()
	{
		$handler =& xoops_gethandler('groupperm');
		$criteria =new CriteriaCompo();
		$criteria->add(new Criteria('gperm_modid', 1));
		$criteria->add(new Criteria('gperm_itemid', $this->get('bid')));
		$criteria->add(new Criteria('gperm_name', 'block_read'));
		
		$gpermArr =&  $handler->getObjects($criteria);
		
		$handler =& xoops_gethandler('group');
		foreach ($gpermArr as $gperm) {
			$this->mGroup[] =& $handler->get($gperm->get('gperm_groupid'));
		}
	}
	
	function loadBmodule()
	{
		$handler =& xoops_getmodulehandler('block_module_link', 'xcore');
		$criteria =new Criteria('block_id', $this->get('bid'));
		
		$this->mBmodule =& $handler->getObjects($criteria);
	}
	
	function loadColumn()
	{
		$handler =& xoops_getmodulehandler('columnside', 'xcore');
		$this->mColumn =& $handler->get($this->get('side'));
	}
	
	function loadCachetime()
	{
		$handler =& xoops_gethandler('cachetime');
		$this->mCachetime =& $handler->get($this->get('bcachetime'));
	}
}
