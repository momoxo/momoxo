<?php

use XCore\Kernel\Identity;

class Xcore_Identity extends Identity
{
	function __construct(&$xoopsUser)
	{
		parent::__construct();
		
		if (!is_object($xoopsUser)) {
			throw new RuntimeException('Exception');
		}
		
		$this->mName = $xoopsUser->get('uname');
	}
	
	function isAuthenticated()
	{
		return true;
	}
}
