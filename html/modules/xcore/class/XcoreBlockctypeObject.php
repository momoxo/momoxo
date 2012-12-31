<?php

use XCore\Entity\SimpleObject;

class XcoreBlockctypeObject extends SimpleObject
{
	function XcoreBlockctypeObject()
	{
		$this->initVar('type', XOBJ_DTYPE_STRING, '', true);
		$this->initVar('label', XOBJ_DTYPE_STRING, '', true, 255);
	}
}
