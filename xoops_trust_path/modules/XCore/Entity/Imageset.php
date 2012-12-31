<?php


namespace XCore\Entity;

use XCore\Entity\Object;

class Imageset extends Object
{

	function __construct()
	{
		parent::__construct();
		$this->initVar('imgset_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('imgset_name', XOBJ_DTYPE_TXTBOX, null, true, 50);
		$this->initVar('imgset_refid', XOBJ_DTYPE_INT, 0, false);
	}
}
