<?php

class XoopsImagesetimg extends XoopsObject
{
	function __construct()
	{
		parent::__construct();
		$this->initVar('imgsetimg_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('imgsetimg_file', XOBJ_DTYPE_OTHER, null, false);
		$this->initVar('imgsetimg_body', XOBJ_DTYPE_SOURCE, null, false);
		$this->initVar('imgsetimg_imgset', XOBJ_DTYPE_INT, null, false);
	}
}
