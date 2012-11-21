<?php

class XcoreImagebodyObject extends XoopsSimpleObject
{
	function XcoreImagebodyObject()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->mVars = $initVars;
			return;
		}
		$this->initVar('image_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('image_body', XOBJ_DTYPE_TEXT, '', true);
		$initVars=$this->mVars;
	}
}

class XcoreImagebodyHandler extends XoopsObjectGenericHandler
{
	var $mTable = "imagebody";
	var $mPrimary = "image_id";
	var $mClass = "XcoreImagebodyObject";
}

?>
