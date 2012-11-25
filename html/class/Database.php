<?php

/**
 * Only for backward compatibility
 * 
 * @deprecated
 */
class Database
{
	/**
	 * @deprecated
	 * @return object
	 */
	public static function getInstance()
	{
		$instance = XoopsDatabaseFactory::getDatabaseConnection();
		return $instance;
	}
}
