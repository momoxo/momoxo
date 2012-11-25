<?php

class XcoreTplsourceObject extends XoopsSimpleObject
{
	function XcoreTplsourceObject()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->mVars = $initVars;
			return;
		}
		$this->initVar('tpl_id', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('tpl_source', XOBJ_DTYPE_TEXT, '', true);
		$initVars=$this->mVars;
	}
}
