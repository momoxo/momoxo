<?php

class XoopsTplset extends XoopsObject
{

	function XoopsTplset()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->vars = $initVars;
			return;
		}
		$this->XoopsObject();
		$this->initVar('tplset_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('tplset_name', XOBJ_DTYPE_OTHER, null, false);
		$this->initVar('tplset_desc', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('tplset_credits', XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('tplset_created', XOBJ_DTYPE_INT, 0, false);
		$initVars = $this->vars;
	}
}
