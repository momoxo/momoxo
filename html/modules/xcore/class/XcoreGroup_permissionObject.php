<?php

use XCore\Entity\SimpleObject;

class XcoreGroup_permissionObject extends SimpleObject
{
	function XcoreGroup_permissionObject()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->mVars = $initVars;
			return;
		}
		$this->initVar('gperm_id', XOBJ_DTYPE_INT, '', true);
		$this->initVar('gperm_groupid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('gperm_itemid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('gperm_modid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('gperm_name', XOBJ_DTYPE_STRING, '', true, 50);
		$initVars=$this->mVars;
	}
}
