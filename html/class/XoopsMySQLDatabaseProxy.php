<?php

/**
 * Read-Only connection to a MySQL database.
 * 
 * This class allows only SELECT queries to be performed through its 
 * {@link query()} method for security reasons.
 * 
 * 
 * @author Kazumi Ono <onokazu@xoops.org>
 * @copyright copyright (c) 2000-2003 XOOPS.org
 * 
 * @package kernel
 * @subpackage database
 */
class XoopsMySQLDatabaseProxy extends XoopsMySQLDatabase
{

    /**
     * perform a query on the database
     * 
     * this method allows only SELECT queries for safety.
     * 
     * @param string $sql a valid MySQL query
     * @param int $limit number of records to return
     * @param int $start offset of first record to return
     * @return resource query result or FALSE if unsuccessful
     */
	function &query($sql, $limit=0, $start=0)
	{
	    $sql = ltrim($sql);
		if (preg_match('/^SELECT/i', $sql)) {
			$ret = $this->queryF($sql, $limit, $start);
			return $ret;
		}
		$this->logger->addQuery($sql, 'Database update not allowed during processing of a GET request', 0);
		
		$ret = false;
		return $ret;
	}
}
