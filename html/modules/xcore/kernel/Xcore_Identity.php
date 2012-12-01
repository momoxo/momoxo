<?php

class Xcore_Identity extends XCube_Identity
{
	function Xcore_Identity(&$xoopsUser)
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
