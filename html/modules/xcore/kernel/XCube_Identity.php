<?php

/**
 * Defines the basic functionality of an identity object.
 */
class XCube_Identity
{
	/**
	 * A name of the identity.
	 * @var string
	 */
	var $mName = "";
	
	/**
	 * The authentication type
	 * @var string
	 */
	var $_mAuthenticationType = "";
	
	function __construct()
	{
	}
	
	/**
	 * Sets the authentication type.
	 * @param string $type
	 */
	function setAuthenticationType($type)
	{
		$this->_mAuthenticationType = $type;
	}
	
	/**
	 * Gets the authentication type.
	 * @return string
	 */
	function getAuthenticationType()
	{
		return $this->_mAuthenticationType;
	}
	
	/**
	 * Sets a name of this object.
	 */
	function setName($name)
	{
		$this->mName = $name;
	}
	
	/**
	 * Gets a name of this object.
	 *
	 * @return string
	 */
	function getName()
	{
		return $this->mName;
	}
	
	/**
	 * Gets a value that indicates whether the user has been authenticated.
	 *
	 * @return bool
	 */
	function isAuthenticated()
	{
	}
}
