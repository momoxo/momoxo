<?php

namespace XCore\Kernel;

use XCore\Kernel\AbstractRequest;

/**
 * A kind of request objects. This class is free to register values.
 */
class GenericRequest extends AbstractRequest
{
	/**
	 * Hash map which stores registered values.
	 * @var array
	 */
	protected $mAttributes = array();

	/**
	 * Return new GenericRequest instance
	 * @param array $arr
	 */
	public function __construct(array $arr = null)
	{
		if ( is_array($arr) ) {
			$this->mAttributes = $arr;
		}
	}

	/**
	 * {@inherit}
	 */
	public function getRequest($key)
	{
		if ( !isset($this->mAttributes[$key]) ) {
			return null;
		}

		return $this->mAttributes[$key];
	}
}
