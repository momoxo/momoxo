<?php


namespace XCore\Repository;

/**
 * XOOPS private message handler class.
 * 
 * This class is responsible for providing data access mechanisms to the data source
 * of XOOPS private message class objects.
 *
 * @package		kernel
 *
 * @author		Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 The XOOPS Project (http://www.xoops.org)
 *
 * @version		$Revision: 1.1 $ - $Date: 2007/05/15 02:34:38 $
 */
use XCore\Repository\ObjectRepository;
use XCore\Database\CriteriaElement;
use XCore\Database\CriteriaCompo;
use XCore\Entity\Privmessage;
use XCore\Database\Criteria;

class PrivmessageRepository extends ObjectRepository
{

/**
 * Create a new {@link Privmessage} object
 * @param 	bool 	$isNew 	Flag as "new"?
 * @return 	object
 **/
    function &create($isNew = true)
    {
        $pm =new Privmessage();
        if ($isNew) {
            $pm->setNew();
        }
        return $pm;
    }

/**
 * Load a {@link Privmessage} object
 * @param 	int 	$id ID of the message
 * @return 	object
 **/
    function &get($id)
    {
        $ret = false;
        $id = (int)$id;
        if ($id > 0) {
            $sql = 'SELECT * FROM '.$this->db->prefix('priv_msgs').' WHERE msg_id='.$id;
            if ($result = $this->db->query($sql)) {
                $numrows = $this->db->getRowsNum($result);
                if ($numrows == 1) {
                        $pm =new Privmessage();
                    $pm->assignVars($this->db->fetchArray($result));
                        $ret =& $pm;
                }
            }
        }
        return $ret;
    }

/**
 * Insert a message in the database
 * @param 	object 	$pm		{@link Privmessage} object
 * @return 	bool
 **/
    function insert(&$pm,$force=false)
    {
        if (strtolower(get_class($pm)) != 'xoopsprivmessage') {
            return false;
        }
        if (!$pm->isDirty()) {
            return true;
        }
        if (!$pm->cleanVars()) {
            return false;
        }
        foreach ($pm->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        if ($pm->isNew()) {
            $msg_id = $this->db->genId('priv_msgs_msg_id_seq');
            $sql = sprintf("INSERT INTO %s (msg_id, msg_image, subject, from_userid, to_userid, msg_time, msg_text, read_msg) VALUES (%u, %s, %s, %u, %u, %u, %s, %u)", $this->db->prefix('priv_msgs'), $msg_id, $this->db->quoteString($msg_image), $this->db->quoteString($subject), $from_userid, $to_userid, time(), $this->db->quoteString($msg_text), 0);
        } else {
            $sql = sprintf("UPDATE %s SET msg_image = %s, subject = %s, from_userid = %u, to_userid = %u, msg_text = %s, read_msg = %u WHERE msg_id = %u", $this->db->prefix('priv_msgs'), $this->db->quoteString($msg_image), $this->db->quoteString($subject), $from_userid, $to_userid, $this->db->quoteString($msg_text), $read_msg, $msg_id);
        }
        
        $result = $force ? $this->db->queryF($sql) : $this->db->query($sql);
        
        if (!$result) {
            return false;
        }
        if (empty($msg_id)) {
            $msg_id = $this->db->getInsertId();
        }
		$pm->assignVar('msg_id', $msg_id);
		
        return true;
    }

/**
 * Delete from the database
 * @param 	object 	$pm 	{@link Privmessage} object
 * @return 	bool
 **/
    function delete(&$pm)
    {
        if (strtolower(get_class($pm)) != 'xoopsprivmessage') {
            return false;
        }
        if (!$result = $this->db->query(sprintf("DELETE FROM %s WHERE msg_id = %u", $this->db->prefix('priv_msgs'), $pm->getVar('msg_id')))) {
            return false;
        }
        return true;
    }

/**
 * Load messages from the database
 * @param 	object 	$criteria 	{@link CriteriaElement} object
 * @param 	bool 	$id_as_key 	use ID as key into the array?
 * @return 	array	Array of {@link Privmessage} objects
 **/
    function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT * FROM '.$this->db->prefix('priv_msgs');
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' '.$criteria->renderWhere();
            $sort = !in_array($criteria->getSort(), array('msg_id', 'msg_time', 'from_userid')) ? 'msg_id' : $criteria->getSort();
            $sql .= ' ORDER BY '.$sort.' '.$criteria->getOrder();
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }
        while ($myrow = $this->db->fetchArray($result)) {
            $pm =new Privmessage();
            $pm->assignVars($myrow);
			if (!$id_as_key) {
            	$ret[] =& $pm;
			} else {
				$ret[$myrow['msg_id']] =& $pm;
			}
            unset($pm);
        }
        return $ret;
    }
    
	/**
	 * Return the collect of private message objects which appointed user received.
	 * @param $uid int user id
	 * @return array of Privmessage.
	 */
    function &getObjectsByFromUid($uid,$start=0,$limit=20,$order = 'DESC')
    {
		$criteria=new Criteria('to_userid',$uid);
		$criteria->addSort('msg_time', $order);
		$criteria->setStart($start);
		$criteria->setLimit($limit);
		$ret =& $this->getObjects($criteria);
		
		return $ret;
	}
	
	function getCountByFromUid($uid)
	{
		return $this->getCount(new Criteria('to_userid',$uid));
	}
	
	function getCountUnreadByFromUid($uid)
	{
		$criteria = new CriteriaCompo(new Criteria('read_msg', 0));
		$criteria->add(new Criteria('to_userid', $uid));
		return $this->getCount($criteria);
	}

/**
 * Count message
 * @param 	object 	$criteria = null 	{@link CriteriaElement} object
 * @return 	int
 **/
    function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('priv_msgs');
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return 0;
        }
        list($count) = $this->db->fetchRow($result);
        return $count;
    }

/**
 * Mark a message as read
 * @param 	object 	$pm 	{@link Privmessage} object
 * @return 	bool
 **/
    function setRead(&$pm)
    {
        if (strtolower(get_class($pm)) != 'xoopsprivmessage') {
            return false;
        }
		$sql = sprintf("UPDATE %s SET read_msg = 1 WHERE msg_id = %u", $this->db->prefix('priv_msgs'), $pm->getVar('msg_id'));
        if (!$this->db->queryF($sql)) {
            return false;
        }
        return true;
    }
}
