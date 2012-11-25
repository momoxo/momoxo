<?php

class XoopsImageset extends XoopsObject
{

	function XoopsImageset()
	{
		$this->XoopsObject();
		$this->initVar('imgset_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('imgset_name', XOBJ_DTYPE_TXTBOX, null, true, 50);
		$this->initVar('imgset_refid', XOBJ_DTYPE_INT, 0, false);
	}
}
