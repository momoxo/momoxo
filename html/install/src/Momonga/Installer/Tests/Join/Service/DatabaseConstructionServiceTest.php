<?php

namespace Momonga\Installer\Tests\Join\Service;

use PDO;
use Momonga\Installer\Service\DatabaseConstructionService;
use Momonga\Installer\Database\SqlUtility;
use Momonga\Installer\Database\ConnectionFactory;
use Momonga\Installer\Tests\SandboxDirectoryManager;
use Momonga\Installer\ValueObject\Database;
use Momonga\Installer\ValueObject\Admin;
use Momonga\Installer\Security\MD5PasswordEncryptor;

/**
 * This join test integrates real MySQL server
 */
class DatabaseConstructionServiceTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var PDO
	 */
	private $pdo;

	protected function setUp()
	{
		try {
			$this->pdo = new PDO('mysql:host='.$_SERVER['XOOPS_TEST_DB_HOST'], $_SERVER['XOOPS_TEST_DB_USER'], $_SERVER['XOOPS_TEST_DB_PASS']);
			$this->pdo->query('DROP DATABASE IF EXISTS '.$_SERVER['XOOPS_TEST_DB_NAME']);
			$this->pdo->query('CREATE DATABASE '.$_SERVER['XOOPS_TEST_DB_NAME']);
			$this->pdo->query('USE '.$_SERVER['XOOPS_TEST_DB_NAME']);
		} catch ( \Exception $e ) {
			$this->markTestSkipped("Cannot connect to database.");
		}

		SandboxDirectoryManager::resetSandboxDirectory();
	}

	public function createDummySchemaFile()
	{
		$dir = SandboxDirectoryManager::getSandboxDirectory();
		$schemaFile = $dir.'/schema.sql';
		file_put_contents($schemaFile, "
			CREATE TABLE foo (
			  foo varchar(255)
			);
			CREATE TABLE users (
			  uid mediumint(8) unsigned NOT NULL auto_increment,
			  name varchar(60) NOT NULL default '',
			  uname varchar(25) NOT NULL default '',
			  email varchar(255) NOT NULL default '',
			  url varchar(100) NOT NULL default '',
			  user_avatar varchar(30) NOT NULL default 'blank.gif',
			  user_regdate int(10) unsigned NOT NULL default '0',
			  user_icq varchar(15) NOT NULL default '',
			  user_from varchar(100) NOT NULL default '',
			  user_sig tinytext NOT NULL,
			  user_viewemail tinyint(1) unsigned NOT NULL default '0',
			  actkey varchar(8) NOT NULL default '',
			  user_aim varchar(18) NOT NULL default '',
			  user_yim varchar(25) NOT NULL default '',
			  user_msnm varchar(100) NOT NULL default '',
			  pass varchar(32) NOT NULL default '',
			  posts mediumint(8) unsigned NOT NULL default '0',
			  attachsig tinyint(1) unsigned NOT NULL default '0',
			  rank smallint(5) unsigned NOT NULL default '0',
			  level tinyint(3) unsigned NOT NULL default '1',
			  theme varchar(100) NOT NULL default '',
			  timezone_offset float(3,1) NOT NULL default '0.0',
			  last_login int(10) unsigned NOT NULL default '0',
			  umode varchar(10) NOT NULL default '',
			  uorder tinyint(1) unsigned NOT NULL default '0',
			  notify_method tinyint(1) NOT NULL default '1',
			  notify_mode tinyint(1) NOT NULL default '0',
			  user_occ varchar(100) NOT NULL default '',
			  bio tinytext NOT NULL,
			  user_intrest varchar(150) NOT NULL default '',
			  user_mailok tinyint(1) unsigned NOT NULL default '1',
			  PRIMARY KEY  (uid),
			  KEY uname (uname),
			  KEY email (email),
			  KEY uiduname (uid,uname),
			  KEY unamepass (uname,pass)
			) ENGINE=InnoDB;");
		return $schemaFile;
	}

	public function createDummyDataFile()
	{
		$dir = SandboxDirectoryManager::getSandboxDirectory();
		$dataFile = $dir.'/data.sql';

		file_put_contents($dataFile, "
			INSERT INTO foo (foo) VALUES ('dummy1');
			INSERT INTO foo (foo) VALUES ('dummy2');
			INSERT INTO foo (foo) VALUES ('dummy3');");
		return $dataFile;
	}

	public function assertTableExists($tableName)
	{
		$this->assertContains($tableName, $this->pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN));
	}

	public function assertTableEquals($expect, $tableName)
	{
		$this->assertSame($expect, $this->pdo->query('SELECT * FROM '.$tableName)->fetchAll(PDO::FETCH_NUM));
	}

	public function assertTableRowCount($count, $tableName)
	{
		$this->assertEquals($count, $this->pdo->query('SELECT COUNT(*) FROM '.$tableName)->fetch(PDO::FETCH_COLUMN));
	}

	public function assertUserTableContains($expect, $uid, $tableName)
	{
		$columns = array_keys($expect);
		$query = sprintf('SELECT %s FROM %s WHERE uid = %s', implode(',', $columns), $tableName, $uid);
		$row = $this->pdo->query($query)->fetch(PDO::FETCH_ASSOC);
		$this->assertEquals($expect, $row);
	}

	public function testConstruct()
	{
		$schemaFile = $this->createDummySchemaFile();
		$dataFile   = $this->createDummyDataFile();

		$database = new Database();
		$database
			->setHost($_SERVER['XOOPS_TEST_DB_HOST'])
			->setUser($_SERVER['XOOPS_TEST_DB_USER'])
			->setPassword($_SERVER['XOOPS_TEST_DB_PASS'])
			->setName($_SERVER['XOOPS_TEST_DB_NAME'])
			->setPrefix('momonga');

		$admin = new Admin();
		$admin
			->setUsername('alice')
			->setEmail('alice@example.com')
			->setPassword('p@ssW0rd')
			->setUrl('http://example.com/')
			->setTimezoneOffset(+9.0);

		$encryptor = new MD5PasswordEncryptor();

		$service = new DatabaseConstructionService();
		$service
			->setConnectionFactory(new ConnectionFactory())
			->setSqlUtility(new SqlUtility())
			->setPasswordEncryptor($encryptor);
		$service->construct($database, $admin, $schemaFile, $dataFile);

		$this->assertTableExists('momonga_foo');
		$this->assertTableExists('momonga_users');

		$this->assertTableEquals(array(
			array('dummy1'),
			array('dummy2'),
			array('dummy3'),
		), 'momonga_foo');

		$this->assertTableRowCount(1, 'momonga_users');
		$this->assertUserTableContains(array(
			'uid'             => '1',
			'uname'           => 'alice',
			'email'           => 'alice@example.com',
			'pass'            => $encryptor->encrypt('p@ssW0rd'),
			'url'             => 'http://example.com/',
			'timezone_offset' => '9.0',
		), 1, 'momonga_users');
	}
}
