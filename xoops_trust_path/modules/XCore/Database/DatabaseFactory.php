<?php


namespace XCore\Database;

use XCore\Kernel\Logger;

class DatabaseFactory
{

	function __construct()
	{
	}

	/**
	 * Get a reference to the only instance of database class and connects to DB
     * 
     * if the class has not been instantiated yet, this will also take 
     * care of that
	 * 
     * @static
     * @staticvar   object  The only instance of database class
     * @return      object  Reference to the only instance of database class
	 */
	public static function &getDatabaseConnection()
	{
		static $instance;
		if (!isset($instance)) {

			// TODO >> この分岐がなくとも動くようにする
			if ( strtolower(XOOPS_DB_TYPE) === 'mysql' ) {
				$dbType = 'MySQL';
			} else {
				$dbType = ucfirst(XOOPS_DB_TYPE);
			}

			/* begin DB Layer Trapping patch */
			if (defined("XOOPS_DB_ALTERNATIVE") && class_exists(XOOPS_DB_ALTERNATIVE)) {
				$class = XOOPS_DB_ALTERNATIVE;
			}
			else if (!defined('XOOPS_DB_PROXY')) {
				$class = 'Xoops'.$dbType.'DatabaseSafe';
			} else {
				$class = 'Xoops'.$dbType.'DatabaseProxy';
			}
			$instance = new $class();
			$instance->setLogger(Logger::instance());
			$instance->setPrefix(XOOPS_DB_PREFIX);
			if (!$instance->connect()) {
				throw new \RuntimeException("Unable to connect to database");
			}
		}
		return $instance;
	}

	/**
	 * Gets a reference to the only instance of database class. Currently
	 * only being used within the installer.
	 * 
     * @static
     * @staticvar   object  The only instance of database class
     * @return      object  Reference to the only instance of database class
	 */
	public static function &getDatabase()
	{
		static $database;
		if (!isset($database)) {
			// TODO >> この分岐がなくとも動くようにする
			if ( strtolower(XOOPS_DB_TYPE) === 'mysql' ) {
				$dbType = 'MySQL';
			} else {
				$dbType = ucfirst(XOOPS_DB_TYPE);
			}

			if (!defined('XOOPS_DB_PROXY')) {
				$class = 'Xoops'.$dbType.'DatabaseSafe';
			} else {
				$class = 'Xoops'.$dbType.'DatabaseProxy';
			}
			$database =new $class();
		}
		return $database;
	}


}
