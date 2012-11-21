<?php

// TODO >> このrequire_onceをなくす
if ( defined('XOOPS_ROOT_PATH') ) {
	require_once XOOPS_ROOT_PATH . '/modules/xcore/include/comment_constants.php';
}

class XcoreColumnsideObject extends XoopsSimpleObject
{
	function XcoreColumnsideObject()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->mVars = $initVars;
			return;
		}
		$this->initVar('id', XOBJ_DTYPE_INT, '', true);
		$this->initVar('name', XOBJ_DTYPE_STRING, '', true, 255);
		$initVars=$this->mVars;
	}
}

class XcoreColumnsideHandler extends XoopsObjectHandler
{
	var $_mResults = array();
	
	function XcoreColumnsideHandler(&$db)
	{
		$t_arr = array (
				0 => _AD_XCORE_LANG_SIDE_BLOCK_LEFT,
				1 => _AD_XCORE_LANG_SIDE_BLOCK_RIGHT,
				3 => _AD_XCORE_LANG_CENTER_BLOCK_LEFT,
				4 => _AD_XCORE_LANG_CENTER_BLOCK_RIGHT,
				5 => _AD_XCORE_LANG_CENTER_BLOCK_CENTER
			);
			
		foreach ($t_arr as $id => $name) {
			$this->_mResults[$id] =& $this->create();
			$this->_mResults[$id]->setVar('id', $id);
			$this->_mResults[$id]->setVar('name', $name);
		}
	}
	
	function &create()
	{
		$ret =new XcoreColumnsideObject();
		return $ret;
	}
	
	function &get($id)
	{
		if (isset($this->_mResults[$id])) {
			return $this->_mResults[$id];
		}
		
		$ret = null;
		return $ret;
	}
	
	function &getObjects($criteria = null, $id_as_key = false)
	{
		if ($id_as_key) {
			return $this->_mResults;
		}
		else {
			$ret = array();
		
			foreach (array_keys($this->_mResults) as $key) {
				$ret[] =& $this->_mResults[$key];
			}
			
			return $ret;
		}
	}
	
	function insert(&$obj)
	{
		return false;
	}

	function delete(&$obj)
	{
		return false;
	}
}

?>
