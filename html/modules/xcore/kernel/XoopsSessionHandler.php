<?php

/**
 * Handler for a session
 * @package     kernel
 * 
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class XoopsSessionHandler
{

    /**
     * Database connection
     * 
     * @var	object
     * @access	private
     */
    var $db;

    /**
     * Constructor
     * 
     * @param	object  &$mf    reference to a XoopsManagerFactory
     * 
     */
    function __construct(&$db)
    {
        $this->db =& $db;
    }

    /**
     * Open a session
     * 
     * @param	string  $save_path
     * @param	string  $session_name
     * 
     * @return	bool
     */
    function open($save_path, $session_name)
	{
        return true;
    }

    /**
     * Close a session
     * 
     * @return	bool
     */
    function close()
	{
        return true;
    }

    /**
     * Read a session from the database
     * 
     * @param	string  &sess_id    ID of the session
     * 
     * @return	array   Session data
     */
    function read($sess_id)
	{
        $sql = sprintf('SELECT sess_data FROM %s WHERE sess_id = %s', $this->db->prefix('session'), $this->db->quoteString($sess_id));
        if (false != $result = $this->db->query($sql)) {
            if (list($sess_data) = $this->db->fetchRow($result)) {
                return $sess_data;
            }
        }
        return '';
    }

    /**
     * Write a session to the database
     * 
     * @param   string  $sess_id
     * @param   string  $sess_data
     * 
     * @return  bool    
     **/
    function write($sess_id, $sess_data)
	{
		$sess_id = $this->db->quoteString($sess_id);
		list($count) = $this->db->fetchRow($this->db->query("SELECT COUNT(*) FROM ".$this->db->prefix('session')." WHERE sess_id=".$sess_id));
        if ( $count > 0 ) {
			$sql = sprintf('UPDATE %s SET sess_updated = %u, sess_data = %s WHERE sess_id = %s', $this->db->prefix('session'), time(), $this->db->quoteString($sess_data), $sess_id);
        } else {
			$sql = sprintf('INSERT INTO %s (sess_id, sess_updated, sess_ip, sess_data) VALUES (%s, %u, %s, %s)', $this->db->prefix('session'), $sess_id, time(), $this->db->quoteString($_SERVER['REMOTE_ADDR']), $this->db->quoteString($sess_data));
        }
		if (!$this->db->queryF($sql)) {
            return false;
        }
		return true;
    }

    /**
     * Destroy a session
     * 
     * @param   string  $sess_id
     * 
     * @return  bool
     **/
    function destroy($sess_id)
    {
		$sql = sprintf('DELETE FROM %s WHERE sess_id = %s', $this->db->prefix('session'), $this->db->quoteString($sess_id));
        if ( !$result = $this->db->queryF($sql) ) {
            return false;
        }
        return true;
    }

    /**
     * Garbage Collector
     * 
     * @param   int $expire Time in seconds until a session expires
	 * @return  bool
     **/
    function gc($expire)
    {
        $mintime = time() - (int)$expire;
		$sql = sprintf('DELETE FROM %s WHERE sess_updated < %u', $this->db->prefix('session'), $mintime);
        return $this->db->queryF($sql);
    }
}
