<?php

use XCore\Kernel\Root;

/**
 * The utility class which handles role information without the root object.
 * @todo このクラス使われていない？
 */
class XCube_Role
{
	function getRolesForUser($username = null)
	{
		$root = Root::getSingleton();
		return $root->mRoleManager->getRolesForUser($username);
	}
}
