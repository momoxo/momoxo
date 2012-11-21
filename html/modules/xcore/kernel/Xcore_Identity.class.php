<?php

class Xcore_Identity extends XCube_Identity
{
	function Xcore_Identity(&$xoopsUser)
	{
		parent::XCube_Identity();
		
		if (!is_object($xoopsUser)) {
			die('Exception');
		}
		
		$this->mName = $xoopsUser->get('uname');
	}
	
	function isAuthenticated()
	{
		return true;
	}
}

class Xcore_AnonymousIdentity extends XCube_Identity
{
	function isAuthenticated()
	{
		return false;
	}
}

/**
 * This principal is free to add roles. And, this is also an interface, because
 * addRole() is used as a common interface in Xcore. Therefore, the dev team
 * may add the interface class to this file.
 * 
 * [Role Naming Convention]
 * Module.{dirname}.Visitor is 'module_read'.
 * Module.{dirname}.Admin is 'module_admin'.
 */
class Xcore_GenericPrincipal extends XCube_Principal
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

?>
