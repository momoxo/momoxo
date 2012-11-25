<?php

class XcoreBlock_module_linkObject extends XoopsSimpleObject
{
	function XcoreBlock_module_linkObject()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->mVars = $initVars;
			return;
		}
		$this->initVar('block_id', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('module_id', XOBJ_DTYPE_INT, '0', true);
		$initVars=$this->mVars;
	}
}
