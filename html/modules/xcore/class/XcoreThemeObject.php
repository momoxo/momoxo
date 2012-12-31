<?php

use XCore\Entity\SimpleObject;

class XcoreThemeObject extends SimpleObject
{
	function XcoreThemeObject()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->mVars = $initVars;
			return;
		}
		$this->initVar('name', XOBJ_DTYPE_STRING, '', true, 255);
		$this->initVar('dirname', XOBJ_DTYPE_STRING, '', true, 255);
		$this->initVar('screenshot', XOBJ_DTYPE_STRING, '', false, 255);
		$this->initVar('description', XOBJ_DTYPE_STRING, '', false, 255);
		$this->initVar('format', XOBJ_DTYPE_STRING, '', true, 255);
		$this->initVar('render_system', XOBJ_DTYPE_STRING, '', true, 255);
		$this->initVar('version', XOBJ_DTYPE_STRING, '', true, 32);
		$this->initVar('author', XOBJ_DTYPE_STRING, '', true, 64);
		$this->initVar('url', XOBJ_DTYPE_STRING, '', true, 255);
		$this->initVar('license', XOBJ_DTYPE_STRING, '', true, 255);
		
		// For TYPO
		$this->initVar('licence', XOBJ_DTYPE_STRING, '', true, 255);
		$initVars = $this->mVars;
	}
}
