<?php

use XCore\Kernel\Root;
use XCore\Kernel\ServiceManager;
use XCore\Kernel\ActionFilter;
use XCore\Kernel\ServiceClient;

class Xcore_NuSoapLoader extends ActionFilter
{
	function preFilter()
	{
		$this->mRoot->mDelegateManager->add('XCore.Kernel.ServiceManager.CreateClient', 'Xcore_NuSoapLoader::createClient');
		$this->mRoot->mDelegateManager->add('XCore.Kernel.ServiceManager.CreateServer', 'Xcore_NuSoapLoader::createServer');
	}
	
	/**
	 * @static
	 */
	public static function createClient(&$client, $service)
	{
		if (is_object($client)) {
			return;
		}

		$root = Root::getSingleton();
		
		if (is_object($service) && is_a($service, 'XCube_Service')) {
			$client = new ServiceClient($service);
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
