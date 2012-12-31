<?php

use XCore\Entity\SimpleObject;

class XcoreColumnsideObject extends SimpleObject
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
