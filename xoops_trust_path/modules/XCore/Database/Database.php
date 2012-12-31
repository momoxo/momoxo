<?php


namespace XCore\Database;

/**
 * Abstract base class for Database access classes
 * 
 * @abstract
 * 
 * @author Kazumi Ono <onokazu@xoops.org>
 * @copyright copyright (c) 2000-2003 XOOPS.org
 * 
 * @package kernel
 * @subpackage database
 */
use XCore\Kernel\Logger;

class Database
{
	/**
	 * Prefix for tables in the database
	 * @var string
	 */
	var $prefix = '';
	/**
	 * reference to a {@link Logger} object
     * @see Logger
	 * @var object Logger
	 */
	var $logger;

	/**
	 * constructor
     *
     * will always fail, because this is an abstract class!
	 */
	function Database()
	{
		// exit("Cannot instantiate this class directly");
	}

	/**
	 * assign a {@link Logger} object to the database
	 *
     * @see Logger
     * @param Logger $logger reference to a {@link Logger} object
	 */
	function setLogger(Logger $logger)
	{
		$this->logger = $logger;
	}

	/**
	 * set the prefix for tables in the database
	 *
     * @param string $value table prefix
	 */
	function setPrefix($value)
	{
		$this->prefix = $value;
	}

	/**
	 * attach the prefix.'_' to a given tablename
     *
     * if tablename is empty, only prefix will be returned
	 *
     * @param string $tablename tablename
     * @return string prefixed tablename, just prefix if tablename is empty
	 */
	function prefix($tablename='')
	{
		if ( $tablename != '' ) {
			return $this->prefix .'_'. $tablename;
		} else {
			return $this->prefix;
		}
	}
}
