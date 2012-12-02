<?php

/**
 * A kind of request objects. This class is free to register values.
 */
use XCore\Kernel\AbstractRequest;

class _GenericRequest extends AbstractRequest
{
	/**
	 * Hash map which stores registered values.
	 * @var Array
	 */
	var $mAttributes = array();
	
	function __construct($arr = null)
	{
		if (is_array($arr)) {
			$this->mAttributes = $arr;
		}
	}

	function getRequest($key)
	{
		if (!isset($this->mAttributes[$key])) {
			return null;
		}
		
		return $this->mAttributes[$key];
	}
}
