<?php

use XCore\Entity\SimpleObject;

class XcoreCommentstatusObject extends SimpleObject
{
	function XcoreCommentstatusObject()
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
