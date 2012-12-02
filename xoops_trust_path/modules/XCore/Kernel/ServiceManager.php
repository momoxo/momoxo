<?php

namespace XCore\Kernel;

use XCore\Kernel\Ref;
use XCore\Kernel\Delegate;
use XCore\Kernel\AbstractServiceClient;
use XCore\Kernel\Service;

/**
 * This class manages Service instances, searches these, creates a much
 * client instance. Now, the purpose of this class is for inside of own XOOPS
 * site. In other words, this class doesn't work for publishing web services.
 * About these separated working, the core team shall examine.
 *
 * XCore namespace can't contain the SOAP library directly. Delegate mechanism
 * is good for this class. This class creates a client instance which to
 * connect to a service, with following the kind of the service. For example,
 * if the specified service is really web service, SOAP client has to be
 * created. But, if the service is a virtual service of XCore, virtual client
 * has to be created.
 */
class ServiceManager
{
	/**
	 * Array of Service instances.
	 * @var Service[]
	 */
	public $mServices = array();

	/**
	 * @var Delegate
	 */
	public $mCreateClient = null;

	/**
	 * @var Delegate
	 */
	public $mCreateServer = null;

	/**
	 * Return new ServiceManager instance
	 */
	public function __construct()
	{
		$this->mCreateClient = new Delegate();
		$this->mCreateClient->register("XCore.Kernel.ServiceManager.CreateClient");

		$this->mCreateServer = new Delegate();
		$this->mCreateServer->register("XCore.Kernel.ServiceManager.CreateServer");
	}

	/**
	 * Add service object. $name must be unique in the list of service. If the
	 * service which has the same name, is a member of the list, return false.
	 *
	 * @param string $name
	 * @param Service $service
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
	 * @return Service
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
	 * But, if the service is a virtual service of XCore, virtual client has to
	 * be created.
	 * @param Service $service
	 * @return AbstractServiceClient|null
	 */
	public function &createClient(&$service)
	{
		$client = null;
		$this->mCreateClient->call(new Ref($client), new Ref($service));

		return $client;
	}

	/**
	 * @param Service $service
	 * @return Service|null
	 */
	public function &createServer(&$service)
	{
		$server = null;
		$this->mCreateServer->call(new Ref($server), new Ref($service));

		return $server;
	}
}
