<?php

namespace Momonga\Installer\Tests\Unit\Service;

use Momonga\Installer\Service\DatabaseConnectionTestService;
use Momonga\Installer\Requirement\DatabaseConnectableRequirement;
use Momonga\Installer\ValueObject\Database;

class DatabaseConnectionTestServiceTest extends \PHPUnit_Framework_TestCase
{
	public function getDatabaseConnectableRequirementStub()
	{
		$stub = $this->getMock('Momonga\Installer\Requirement\DatabaseConnectableRequirement', array('isSatisfiedBy'));
		return $stub;
	}

	public function returnFalse()
	{
		return $this->returnValue(false);
	}

	public function returnTrue()
	{
		return $this->returnValue(true);
	}

	public function testWithNotSatisfiedDatabase()
	{
		// Create dummy database object
		$database = new Database();

		// Get requirement stub
		$requirement = $this->getDatabaseConnectableRequirementStub();

		// Requirement's behavior
		$requirement
			->expects($this->once())
			->method('isSatisfiedBy')
			->with($database)
			->will($this->returnFalse());

		// Set up service object
		$service = new DatabaseConnectionTestService();
		$service
			->setDatabaseConnectableRequirement($requirement);

		// Test
		$this->assertFalse($service->test($database));
	}

	public function testWithSatisfiedDatabase()
	{
		// Create dummy database object
		$database = new Database();

		// Get requirement stub
		$requirement = $this->getDatabaseConnectableRequirementStub();

		// Requirement's behavior
		$requirement
			->expects($this->once())
			->method('isSatisfiedBy')
			->with($database)
			->will($this->returnTrue());

		// Set up service object
		$service = new DatabaseConnectionTestService();
		$service
			->setDatabaseConnectableRequirement($requirement);

		// Test
		$this->assertTrue($service->test($database));
	}
}
