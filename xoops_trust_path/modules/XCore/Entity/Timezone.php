<?php


namespace XCore\Entity;

use XCore\Entity\Object;

class Timezone extends Object
{
	function __construct()
	{
		static $initVars;
		if (isset($initVars)) {
		    $this->vars = $initVars;
		    return;
		}
		$this->initVar('offset', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('zone_name', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $initVars = $this->vars;
	}
}