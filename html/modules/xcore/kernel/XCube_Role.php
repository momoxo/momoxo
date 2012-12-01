<?php

/**
 * The utility class which handles role information without the root object.
 */
use XCore\Kernel\Root;

class XCube_Role
{
	function getRolesForUser($username = null)
	{
		$root = Root::getSingleton();
		return $root->mRoleManager->getRolesForUser($username);
	}
}
