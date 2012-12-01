<?php

namespace XCore\Kernel;

use XCube_Delegate;
use XCube_Service;
use XCube_AbstractServiceClient;
use XCube_Ref;

/**
 * This class manages XCube_Service instances, searches these, creates a much
 * client instance. Now, the purpose of this class is for inside of own XOOPS
 * site. In other words, this class doesn't work for publishing web services.
 * About these separated working, the core team shall examine.
 *
 * XCube namespace can't contain the SOAP library directly. Delegate mechanism
 * is good for this class. This class creates a client instance which to
 * connect to a service, with following the kind of the service. For example,
 * if the specified service is really web service, SOAP client has to be
 * created. But, if the service is a virtual service of XCube, virtual client
 * has to be created.
 */
class ServiceManager
{
	/**
	 * Array of XCube_Service instances.
	 * @var XCube_Service[]
	 */
	public $mServices = array();

	/**
	 * @var XCube_Delegate
	 */
	public $mCreateClient = null;

	/**
	 * @var XCube_Delegate
	 */
	public $mCreateServer = null;

	/**
	 * Return new ServiceManager instance
	 */
	public function __construct()
	{
		$this->mCreateClient = new XCube_Delegate();
		$this->mCreateClient->register("XCore.Kernel.ServiceManager.CreateClient");

		$this->mCreateServer = new XCube_Delegate();
		$this->mCreateServer->register("XCore.Kernel.ServiceManager.CreateServer");
	}

	/**
	 * Add service object. $name must be unique in the list of service. If the
	 * service which has the same name, is a member of the list, return false.
	 *
	 * @param string $name
	 * @param XCube_Service $service
	 * @return bool
	 */
	public function addService($name, &$service)
	{
		if (isset($this->mServices[$name])) {
			return false;
		}

		$this->mServices[$name] =& $service;

		return true;
	}

	/**
	 * Add WSDL URL. $name must be unique in the list of service. If the
	 * service which has the same name, is a member of the list, return false.
	 * @param $name
	 * @param $url
	 * @return bool
	 */
	public function addWSDL($name, $url)
	{
		if (isset($this->mServices[$name])) {
			return false;
		}

		$this->mServices[$name] =& $url;

		return true;
	}

	/**
	 * @param string $name
	 * @return XCube_Service
	 */
	public function &getService($name)
	{
		$ret = null;

		if (isset($this->mServices[$name])) {
			return $this->mServices[$name];
		}

		return $ret;
	}

	/**
	 * Create client instance which to connect to a service, with following the
	 * kind of the service. Then return that instance. For example, if the
	 * specified service is really web service, SOAP client has to be created.
	 * But, if the service is a virtual service of XCube, virtual client has to
	 * be created.
	 * @param XCube_Service $service
	 * @return XCube_AbstractServiceClient|null
	 */
	public function &createClient(&$service)
	{
		$client = null;
		$this->mCreateClient->call(new XCube_Ref($client), new XCube_Ref($service));

		return $client;
	}

	/**
	 * @param XCube_Service $service
	 * @return XCube_Service|null
	 */
	public function &createServer(&$service)
	{
		$server = null;
		$this->mCreateServer->call(new XCube_Ref($server), new XCube_Ref($service));

		return $server;
	}
}
