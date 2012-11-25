<?php

/**
 * Safe Connection to a MySQL database.
 * 
 * 
 * @author Kazumi Ono <onokazu@xoops.org>
 * @copyright copyright (c) 2000-2003 XOOPS.org
 * 
 * @package kernel
 * @subpackage database
 */
class XoopsMySQLDatabaseSafe extends XoopsMySQLDatabase
{

    /**
     * perform a query on the database
     * 
     * @param string $sql a valid MySQL query
     * @param int $limit number of records to return
     * @param int $start offset of first record to return
     * @return resource query result or FALSE if successful
     * or TRUE if successful and no result
     */
	function &query($sql, $limit=0, $start=0)
	{
		$result =& $this->queryF($sql, $limit, $start);
		return $result;
	}
}
