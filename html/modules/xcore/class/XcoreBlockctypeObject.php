<?php

class XcoreBlockctypeObject extends XoopsSimpleObject
{
	function XcoreBlockctypeObject()
	{
		$this->initVar('type', XOBJ_DTYPE_STRING, '', true);
		$this->initVar('label', XOBJ_DTYPE_STRING, '', true, 255);
	}
}
