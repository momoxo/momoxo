<?php

class Xcore_NuSoapLoader extends XCube_ActionFilter
{
	function preFilter()
	{
		$this->mRoot->mDelegateManager->add('XCube_ServiceManager.CreateClient', 'Xcore_NuSoapLoader::createClient');
		$this->mRoot->mDelegateManager->add('XCube_ServiceManager.CreateServer', 'Xcore_NuSoapLoader::createServer');
	}
	
	/**
	 * @static
	 */
	public static function createClient(&$client, $service)
	{
		if (is_object($client)) {
			return;
		}

		$root =& XCube_Root::getSingleton();
		
		if (is_object($service) && is_a($service, 'XCube_Service')) {
			$client = new XCube_ServiceClient($service);
		}
		else {
			$client = new ShadePlus_SoapClient($service);
		}
	}

	/**
	 * @static
	 */
	function createServer(&$server, $service)
	{
		if (is_object($server) || !is_object($service)) {
			return;
		}

		$server = new ShadePlus_ServiceServer($service);
		$server->prepare();
	}
}
