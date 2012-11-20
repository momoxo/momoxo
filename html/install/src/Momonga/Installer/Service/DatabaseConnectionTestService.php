<?php

namespace Momonga\Installer\Service;

use Momonga\Installer\Requirement\DatabaseConnectableRequirement;
use Momonga\Installer\ValueObject\Database;

/**
 * Database connection test
 */
class DatabaseConnectionTestService
{
	/**
	 * @var DatabaseConnectableRequirement
	 */
	private $databaseConnectableRequirement;

	/**
	 * @param DatabaseConnectableRequirement $databaseConnectableRequirement
	 * @return DatabaseConnectionTestService
	 */
	public function setDatabaseConnectableRequirement(DatabaseConnectableRequirement $databaseConnectableRequirement)
	{
		$this->databaseConnectableRequirement = $databaseConnectableRequirement;
		return $this;
	}

	/**
	 * Test if the database can be connected
	 * @param Database $database
	 * @return bool
	 */
	public function test(Database $database)
	{
		return $this->databaseConnectableRequirement->isSatisfiedBy($database);
	}
}
