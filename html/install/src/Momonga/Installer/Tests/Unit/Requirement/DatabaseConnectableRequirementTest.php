<?php

namespace Momonga\Installer\Tests\Unit\Requirement;

use Momonga\Installer\Requirement\DatabaseConnectableRequirement;
use Momonga\Installer\Database\ConnectionFactory;
use Momonga\Installer\ValueObject\Database;

/**
 * @backupGlobals disabled
 */
class DatabaseConnectableRequirementTest extends \PHPUnit_Framework_TestCase
{
	public function getConnectionFactoryStub()
	{
		$stub = $this->getMock('Momonga\Installer\Database\ConnectionFactory');
		return $stub;
	}

	public function getDummyPDO()
	{
		$dummyPDO = $this->getMock('stdClass');
		return $dummyPDO;
	}

	public function getDatabase()
	{
		$database = new Database();
		$database
			->setHost('localhost')
			->setUser('root')
			->setPassword('root')
			->setName('momoxo');
		return $database;
	}

	public function testWithConnectableDatabase()
	{
		// Create stub
		$connectionFactory = $this->getConnectionFactoryStub();

		// Connection factory behavior
		$connectionFactory
			->expects($this->once())
			->method('create')
			->with('localhost', 'root', 'root')
			->will($this->returnValue($this->getDummyPDO()));

		// Set up requirement object
		$requirement = new DatabaseConnectableRequirement();
		$requirement->setConnectionFactory($connectionFactory);

		// Test
		$database = $this->getDatabase();
		$this->assertTrue($requirement->isSatisfiedBy($database));
	}

	public function testWithNotConnectableDatabase()
	{
		// Create stub
		$connectionFactory = $this->getConnectionFactoryStub();

		// Connection factory behavior
		$connectionFactory
			->expects($this->once())
			->method('create')
			->with('localhost', 'root', 'root')
			->will($this->throwException(new \PDOException('This is dummy exception')));

		// Set up requirement object
		$requirement = new DatabaseConnectableRequirement();
		$requirement->setConnectionFactory($connectionFactory);

		// Test
		$database = $this->getDatabase();
		$this->assertFalse($requirement->isSatisfiedBy($database));
	}
}
