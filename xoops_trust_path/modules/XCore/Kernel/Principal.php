<?php

namespace XCore\Kernel;

use XCore\Kernel\Identity;

/**
 * Defines the basic functionality of a principal object.
 */
class Principal
{
	/**
	 * The identity object which is tied to this object.
	 * @var Identity
	 */
	public $mIdentity = null;

	/**
	 * Roles in this object.
	 * @var string[]
	 */
	protected $_mRoles = array();

	/**
	 * @param Identity $identity
	 * @param array $roles
	 */
	public function __construct($identity, $roles = array())
	{
		$this->mIdentity =& $identity;
		$this->_mRoles = $roles;
	}

	/**
	 * Gets a identity object which is tied to this object.
	 * @return Identity
	 */
	public function getIdentity()
	{
		return $this->mIdentity;
	}

	/**
	 * Gets a value that indicates whether this principal has a role specified by $rolename.
	 * @var string $rolename
	 * @return bool
	 */
	public function isInRole($rolename)
	{
	}
}
