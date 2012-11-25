<?php

class XoopsSubjecticon extends XoopsObject
{
	function XoopsSubjecticon()
	{
        $this->initVar('filename', XOBJ_DTYPE_TXTBOX, null, true, 255);
	}
}
