<?php

/**
 * The utility class which handles role information without the root object.
 */
class XCube_Role
{
	function getRolesForUser($username = null)
	{
		$root =& XCube_Root::getSingleton();
		return $root->mRoleManager->getRolesForUser($username);
	}
}
