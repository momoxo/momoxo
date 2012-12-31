<?php

class XoopsSubjecticon extends XoopsObject
{
	function __construct()
	{
        $this->initVar('filename', XOBJ_DTYPE_TXTBOX, null, true, 255);
	}
}
