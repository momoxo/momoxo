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
