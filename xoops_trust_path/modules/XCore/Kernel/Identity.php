<?php

namespace XCore\Kernel;

/**
 * Defines the basic functionality of an identity object.
 */
class Identity
{
	/**
	 * A name of the identity.
	 * @var string
	 */
	protected $mName = "";

	/**
	 * The authentication type
	 * @var string
	 */
	protected $_mAuthenticationType = "";

	/**
	 * Return new Identity instance
	 */
	public function __construct()
	{
	}

	/**
	 * Sets the authentication type.
	 * @param string $type
	 * @return void
	 */
	public function setAuthenticationType($type)
	{
		$this->_mAuthenticationType = $type;
	}

	/**
	 * Gets the authentication type.
	 * @return string
	 */
	public function getAuthenticationType()
	{
		return $this->_mAuthenticationType;
	}

	/**
	 * Sets a name of this object.
	 * @return void
	 */
	public function setName($name)
	{
		$this->mName = $name;
	}

	/**
	 * Gets a name of this object.
	 * @return string
	 */
	public function getName()
	{
		return $this->mName;
	}

	/**
	 * Gets a value that indicates whether the user has been authenticated.
	 * @return bool
	 */
	public function isAuthenticated()
	{
	}
}

