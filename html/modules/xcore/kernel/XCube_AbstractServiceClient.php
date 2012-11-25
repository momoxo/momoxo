<?php

/**
 * @public
 * @brief [Experiment Class] The adapter for a service class.
 * 
 * This class is the adapter of a service class.
 * I give a caller the interface that resembled NUSOAP.
 */
class XCube_AbstractServiceClient
{
	var $mService;
	var $mClientErrorStr;
	
	var $mUser = null;
	
	function XCube_AbstractServiceClient(&$service)
	{
		$this->mService =& $service;
	}
	
	function prepare()
	{
	}
	
	function setUser(&$user)
	{
		$this->mUser =& $user;
	}

	function call($operation, $params)
	{
	}
	
	function getOperationData($operation)
	{
	}

	function setError($message)
	{
		$this->mClientErrorStr = $message;
	}

	function getError()
	{
		return !empty($this->mClientErrorStr) ? $this->mClientErrorStr : $this->mService->mErrorStr;
	}
}
