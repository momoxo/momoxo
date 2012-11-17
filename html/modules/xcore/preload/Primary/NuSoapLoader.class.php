<?php
/**
 *
 * @package Xcore
 * @version $Id: NuSoapLoader.class.php,v 1.3 2008/09/25 15:12:38 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined("XOOPS_ROOT_PATH")) exit();

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
	function createClient(&$client, $service)
	{
		if (is_object($client)) {
			return;
		}

		$root =& XCube_Root::getSingleton();
		
		if (is_object($service) && is_a($service, 'XCube_Service')) {
			$client = new XCube_ServiceClient($service);
		}
		else {
			require_once XOOPS_ROOT_PATH . "/modules/xcore/lib/nusoap/nusoap.php";
			require_once XOOPS_ROOT_PATH . "/modules/xcore/lib/ShadePlus/SoapClient.class.php";
			
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
		
		require_once XOOPS_ROOT_PATH . "/modules/xcore/lib/nusoap/nusoap.php";
		require_once XOOPS_ROOT_PATH . "/modules/xcore/lib/ShadePlus/ServiceServer.class.php";
		require_once XOOPS_ROOT_PATH . "/modules/xcore/lib/ShadeSoap/NusoapServer.class.php";
		
		$server = new ShadePlus_ServiceServer($service);
		$server->prepare();
	}
}

?>
