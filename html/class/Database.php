<?php

/**
 * Only for backward compatibility
 * 
 * @deprecated
 */
use XCore\Database\DatabaseFactory;

class Database
{
	/**
	 * @deprecated
	 * @return object
	 */
	public static function getInstance()
	{
		$instance = DatabaseFactory::getDatabaseConnection();
		return $instance;
	}
}
