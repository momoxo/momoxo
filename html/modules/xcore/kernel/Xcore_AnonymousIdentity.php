<?php

class Xcore_AnonymousIdentity extends XCube_Identity
{
	function isAuthenticated()
	{
		return false;
	}
}
