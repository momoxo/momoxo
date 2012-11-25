<?php

class XcoreBlockctypeHandler extends XoopsObjectHandler
{
	var $_mResults = array();
	
	function XcoreBlockctypeHandler(&$db)
	{
		$t_arr = array (
				'H' => _AD_XCORE_LANG_CTYPE_HTML,
				'P' => _AD_XCORE_LANG_CTYPE_PHP,
				'S' => _AD_XCORE_LANG_CTYPE_WITH_SMILIES,
				'T' => _AD_XCORE_LANG_CTYPE_WITHOUT_SMILIES
			);
			
		foreach ($t_arr as $id => $name) {
			$this->_mResults[$id] =& $this->create();
			$this->_mResults[$id]->setVar('type', $id);
			$this->_mResults[$id]->setVar('label', $name);
		}
	}
	
	function &create()
	{
		$ret =new XcoreBlockctypeObject();
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
