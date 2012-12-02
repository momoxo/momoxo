<?php

use XCore\Kernel\Identity;

class Xcore_AnonymousIdentity extends Identity
{
	function isAuthenticated()
	{
		return false;
	}
}
