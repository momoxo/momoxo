<?php

/**
 * Defines the basic functionality of a principal object.
 */
class XCube_Principal
{
	/**
	 * The identity object which is tied to this object.
	 */
	var $mIdentity = null;
	
	/**
	 * Roles in this object.
	 * @var string[]
	 */
	var $_mRoles = array();
	
	function __construct($identity, $roles = array())
	{
		$this->mIdentity =& $identity;
		$this->_mRoles = $roles;
	}
	
	/**
	 * Gets a identity object which is tied to this object.
	 * @return XCube_Identity
	 */
	function getIdentity()
	{
		return $this->mIdentity;
	}
	
	/**
	 * Gets a value that indicates whether this principal has a role specified by $rolename.
	 *
	 * @var string $rolename
	 * @return bool
	 */	
	function isInRole($rolename)
	{
	}
}
