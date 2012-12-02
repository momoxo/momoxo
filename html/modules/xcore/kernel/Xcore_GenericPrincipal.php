<?php

/**
 * This principal is free to add roles. And, this is also an interface, because
 * addRole() is used as a common interface in Xcore. Therefore, the dev team
 * may add the interface class to this file.
 * 
 * [Role Naming Convention]
 * Module.{dirname}.Visitor is 'module_read'.
 * Module.{dirname}.Admin is 'module_admin'.
 */
use XCore\Kernel\Principal;

class Xcore_GenericPrincipal extends Principal
{
	/**
	 * Adds a role to this object.
	 * @param $roleName string
	 */
	function addRole($roleName)
	{
		if (!$this->isInRole($roleName)) {
			$this->_mRoles[] = $roleName;
		}
	}
	
	function isInRole($roleName)
	{
		return in_array($roleName, $this->_mRoles);
	}
}
