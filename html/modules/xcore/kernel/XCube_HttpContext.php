<?php

/**
 * Encapsulates major HTTP specific information about a HTTP request.
 */
class XCube_HttpContext
{
	/**
	 * Hashmap that can be used to organize and share data. Use setAttribute()
	 * and get Attribute() to access this member property. But, direct access
	 * is allowed, because PHP4 is unpossible to handle reference well.
	 *
	 * @var Array
	 * @access protected
	 */
	var $mAttributes = array();
	
	/**
	 * The object which enables to read the request values.
	 *
	 * @access XCube_AbstractRequest
	 */
	var $mRequest = null;
	
	/**
	 * @var XCube_Principal
	 */
	var $mUser = null;
	
	/**
	 * String which expresses the type of the current request.
	 * @var string
	 */
	var $mType = XCUBE_CONTEXT_TYPE_DEFAULT;

	/**
	 * The theme is one in one time of request.
	 * A decided theme is registered with this property
	 *
	 * @access private
	 */
	var $mThemeName = null;
	
	function __construct()
	{
	}
	
	/**
	 * Sets $value with $key to attributes. Use direct access to $mAttributes
	 * if references are must, because PHP4 can't handle reference in the
	 * signature of this member function.
	 * 
	 * @param string $key
	 * @param mixed $value
	 */
	function setAttribute($key, $value)
	{
		$this->mAttributes[$key] = $value;
	}

	/**
	 * Gets a value indicating whether the value specified by $key exists.
	 * 
	 * @param string $key
	 * @return mixed
	 */	
	function hasAttribute($key)
	{
		return isset($this->mAttributes[$key]);
	}
	
	/**
	 * Gets a value of attributes with $key. If the value specified by $key
	 * doesn't exist in attributes, gets null.
	 * 
	 * @param string $key
	 * @return mixed
	 */	
	function getAttribute($key)
	{
		return isset($this->mAttributes[$key]) ? $this->mAttributes[$key] : null;
	}

	/**
	 * Sets the object which has a interface of XCube_AbstractRequest.
	 *
	 * @param XCube_AbstractRequest $request
	 */	
	function setRequest(&$request)
	{
		$this->mRequest =& $request;
	}
	
	/**
	 * Gets the object which has a interface of XCube_AbstractRequest.
	 *
	 * @return XCube_AbstractRequest
	 */	
	function &getRequest()
	{
		return $this->mRequest;
	}

	/**
	 * Sets the object which has a interface of XCube_Principal.
	 *
	 * @param XCube_AbstractPrincipal $principal
	 */
	function setUser(&$principal)
	{
		$this->mUser =& $principal;
	}
	
	/**
	 * Gets the object which has a interface of XCube_Principal.
	 *
	 * @return XCube_AbstractPrincipal
	 */
	function &getUser()
	{
		return $this->mUser;
	}

	/**
	 * Set the theme name.
	 * 
	 * @param $theme string
	 * @deprecated
	 */	
	function setThemeName($theme)
	{
		$this->mThemeName = $theme;
	}
	
	/**
	 * Return the theme name.
	 * 
	 * @return string
	 * @deprecated
	 */	
	function getThemeName()
	{
		return $this->mThemeName;
	}
}
