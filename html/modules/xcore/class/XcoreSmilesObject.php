<?php

class XcoreSmilesObject extends XoopsSimpleObject
{
	function XcoreSmilesObject()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->mVars = $initVars;
			return;
		}
		$this->initVar('id', XOBJ_DTYPE_INT, '', true);
		$this->initVar('code', XOBJ_DTYPE_STRING, '', true, 50);
		$this->initVar('smile_url', XOBJ_DTYPE_STRING, '', true, 100);
		$this->initVar('emotion', XOBJ_DTYPE_STRING, '', true, 75);
		$this->initVar('display', XOBJ_DTYPE_BOOL, '0', true);
		$initVars=$this->mVars;
	}
}
