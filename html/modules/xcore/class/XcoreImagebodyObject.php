<?php

use XCore\Entity\SimpleObject;

class XcoreImagebodyObject extends SimpleObject
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
