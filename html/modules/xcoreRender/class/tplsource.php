<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

class XcoreRenderTplsourceObject extends XoopsSimpleObject
{
	function XcoreRenderTplsourceObject()
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

class XcoreRenderTplsourceHandler extends XoopsObjectGenericHandler
{
	var $mTable = "tplsource";
	var $mPrimary = "tpl_id";
	var $mClass = "XcoreRenderTplsourceObject";
}

?>
