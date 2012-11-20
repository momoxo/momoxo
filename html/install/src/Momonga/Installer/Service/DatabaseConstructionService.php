<?php

namespace Momonga\Installer\Service;

use Momonga\Installer\Database\ConnectionFactory;
use Momonga\Installer\Database\SqlUtility;
use Momonga\Installer\ValueObject\Database;
use Momonga\Installer\ValueObject\Admin;
use Momonga\Installer\Security\PasswordEncryptorInterface;

/**
 * データベース構築サービス
 */
class DatabaseConstructionService
{
	/**
	 * @var ConnectionFactory
	 */
	private $connectionFactory;

	/**
	 * @var SqlUtility
	 */
	private $sqlUtility;

	/**
	 * @var PasswordEncryptorInterface
	 */
	private $encryptor;

	/**
	 * @param ConnectionFactory $connectionFactory
	 * @return DatabaseConstructionService
	 */
	public function setConnectionFactory(ConnectionFactory $connectionFactory)
	{
		$this->connectionFactory = $connectionFactory;
		return $this;
	}

	/**
	 * @param SqlUtility $sqlUtility
	 * @return DatabaseConstructionService
	 */
	public function setSqlUtility(SqlUtility $sqlUtility)
	{
		$this->sqlUtility = $sqlUtility;
		return $this;
	}

	/**
	 * @param PasswordEncryptorInterface $passwordEncryptor
	 * @return DatabaseConstructionService
	 */
	public function setPasswordEncryptor(PasswordEncryptorInterface $passwordEncryptor)
	{
		$this->encryptor = $passwordEncryptor;
		return $this;
	}

	/**
	 * Construct database
	 * @param Database $database
	 * @param Admin    $admin
	 * @param string $schemaFile
	 * @param string $dataFile
	 * @throws \Exception
	 */
	public function construct(Database $database, Admin $admin, $schemaFile, $dataFile)
	{
		$connection = $this->connectionFactory->createWithDatabase($database);

		$queries = array_merge(
			$this->_splitQueries(file_get_contents($schemaFile)),
			$this->_splitQueries(file_get_contents($dataFile))
		);

		foreach ( $queries as $query ) {
			$queryInfo = $this->sqlUtility->prefixQuery($query, $database->getPrefix());
			$connection->query($queryInfo[0]);
		}

		// TODO >> どのカラムがどの値か一目瞭然にする
		$statement = $connection->prepare("
			INSERT INTO ".$database->getPrefix()."_users (
				uid, name, uname, email, url, user_avatar, user_regdate, user_icq,
				user_from, user_sig, user_viewemail, actkey, user_aim, user_yim,
				user_msnm, pass, posts, attachsig, rank, level, theme, timezone_offset,
				last_login, umode, uorder, notify_method, notify_mode, user_occ, bio,
				user_intrest, user_mailok)
			VALUES (
				1, '', :uname, :email, :url, 'blank.gif', :user_regdate, '', '', '', 1,
				'', '', '', '', :pass, 0, 0, 7, 5, '', :timezone_offset, :last_login,
				'thread', 0, 1, 0, '', '', '', 0);
		");

		$statement->execute(array(
			':uname'           => $admin->getUsername(),
			':email'           => $admin->getEmail(),
			':url'             => $admin->getUrl(),
			':user_regdate'    => $admin->getRegisteredDate(),
			':pass'            => $this->encryptor->encrypt($admin->getPassword()),
			':timezone_offset' => $admin->getTimezoneOffset(),
			':last_login'      => $admin->getLastLogin(),
		));
	}

	/**
	 * @param string $sql
	 * @return string[]
	 */
	private function _splitQueries($sql)
	{
		$queries = array();
		$this->sqlUtility->splitMySqlFile($queries, $sql);
		return $queries;
	}
}
