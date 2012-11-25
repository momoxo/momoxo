<?php

/**
 * XCube_PermissionUtils
 */
class XCube_Permissions
{
	function getRolesOfAction()
	{
		$args = func_get_args();
		$actionName = array_shift($args);
		
		$root =& XCube_Root::getSingleton();
		return $root->mPermissionManager->getRolesOfAction($actionName, $args);
	}
}
