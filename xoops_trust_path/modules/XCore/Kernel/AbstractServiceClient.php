<?php

namespace XCore\Kernel;

use XCore\Kernel\Service;

/**
 * The adapter for a service class.
 *
 * This class is the adapter of a service class.
 * I give a caller the interface that resembled NUSOAP.
 */
abstract class AbstractServiceClient
{
	/**
	 * @var Service
	 */
	protected $mService;

	/**
	 * @var string
	 */
	protected $mClientErrorStr;

	protected $mUser = null;

	/**
	 * @param Service $service
	 */
	public function __construct(&$service)
	{
		$this->mService =& $service;
	}

	public function prepare()
	{
	}

	public function setUser(&$user)
	{
		$this->mUser =& $user;
	}

	public function call($operation, $params)
	{
	}

	public function getOperationData($operation)
	{
	}

	public function setError($message)
	{
		$this->mClientErrorStr = $message;
	}

	public function getError()
	{
		return !empty($this->mClientErrorStr) ? $this->mClientErrorStr : $this->mService->mErrorStr;
	}
}

