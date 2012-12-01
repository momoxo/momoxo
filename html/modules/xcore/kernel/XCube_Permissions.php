<?php

/**
 * XCube_PermissionUtils
 */
use XCore\Kernel\Root;

class XCube_Permissions
{
	function getRolesOfAction()
	{
		$args = func_get_args();
		$actionName = array_shift($args);
		
		$root =& Root::getSingleton();
		return $root->mPermissionManager->getRolesOfAction($actionName, $args);
	}
}
