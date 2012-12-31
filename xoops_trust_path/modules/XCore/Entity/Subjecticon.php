<?php


namespace XCore\Entity;

use XCore\Entity\Object;

class Subjecticon extends Object
{
	function __construct()
	{
        $this->initVar('filename', XOBJ_DTYPE_TXTBOX, null, true, 255);
	}
}
