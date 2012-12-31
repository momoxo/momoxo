<?php


namespace XCore\Entity;

use XCore\Entity\Object;

class Cachetime extends Object
{
	function __construct()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->vars = $initVars;
			return;
		}
		$this->initVar('cachetime', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('label', XOBJ_DTYPE_TXTBOX, null, true, 255);
		$initVars = $this->vars;
	}
}
