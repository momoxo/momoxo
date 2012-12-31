<?php


namespace XCore\Repository;

/**
 * XOOPS comment handler class.  
 * 
 * This class is responsible for providing data access mechanisms to the data source 
 * of XOOPS comment class objects.
 *
 * 
 * @package     kernel
 * @subpackage  comment
 * 
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
use XCore\Repository\ObjectRepository;
use XCore\Database\CriteriaElement;
use XCore\Database\CriteriaCompo;
use XCore\Database\Criteria;
use XCore\Entity\Comment;

class CommentRepository extends ObjectRepository
{

    /**
     * Create a {@link Comment} 
     * 
     * @param	bool    $isNew  Flag the object as "new"?
     * 
     * @return	object
     */
    function &create($isNew = true)
    {
        $comment =new Comment();
        if ($isNew) {
            $comment->setNew();
        }
        return $comment;
    }

    /**
     * Retrieve a {@link Comment} 
     * 
     * @param   int $id ID
     * 
     * @return  object  {@link Comment}, FALSE on fail
     **/
    function &get($id)
    {
        $ret = false;
        $id = (int)$id;
        if ($id > 0) {
            $sql = 'SELECT * FROM '.$this->db->prefix('xoopscomments').' WHERE com_id='.$id;
            if ($result = $this->db->query($sql)) {
                $numrows = $this->db->getRowsNum($result);
                if ($numrows == 1) {
                    $comment = new Comment();
                    $comment->assignVars($this->db->fetchArray($result));
                        $ret =& $comment;
                }
            }
        }
        return $ret;
    }

    /**
     * Write a comment to database
     * 
     * @param   object  &$comment
     * 
     * @return  bool
     **/
    function insert(&$comment)
    {
        if (strtolower(get_class($comment)) != 'xoopscomment') {
            return false;
        }
        if (!$comment->isDirty()) {
            return true;
        }
        if (!$comment->cleanVars()) {
            return false;
        }
        foreach ($comment->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        if ($comment->isNew()) {
            $com_id = $this->db->genId('xoopscomments_com_id_seq');
            $sql = sprintf("INSERT INTO %s (com_id, com_pid, com_modid, com_icon, com_title, com_text, com_created, com_modified, com_uid, com_ip, com_sig, com_itemid, com_rootid, com_status, com_exparams, dohtml, dosmiley, doxcode, doimage, dobr) VALUES (%u, %u, %u, %s, %s, %s, %u, %u, %u, %s, %u, %u, %u, %u, %s, %u, %u, %u, %u, %u)", $this->db->prefix('xoopscomments'), $com_id, $com_pid, $com_modid, $this->db->quoteString($com_icon), $this->db->quoteString($com_title), $this->db->quoteString($com_text), $com_created, $com_modified, $com_uid, $this->db->quoteString($com_ip), $com_sig, $com_itemid, $com_rootid, $com_status, $this->db->quoteString($com_exparams), $dohtml, $dosmiley, $doxcode, $doimage, $dobr);
        } else {
            $sql = sprintf("UPDATE %s SET com_pid = %u, com_icon = %s, com_title = %s, com_text = %s, com_created = %u, com_modified = %u, com_uid = %u, com_ip = %s, com_sig = %u, com_itemid = %u, com_rootid = %u, com_status = %u, com_exparams = %s, dohtml = %u, dosmiley = %u, doxcode = %u, doimage = %u, dobr = %u WHERE com_id = %u", $this->db->prefix('xoopscomments'), $com_pid, $this->db->quoteString($com_icon), $this->db->quoteString($com_title), $this->db->quoteString($com_text), $com_created, $com_modified, $com_uid, $this->db->quoteString($com_ip), $com_sig, $com_itemid, $com_rootid, $com_status, $this->db->quoteString($com_exparams), $dohtml, $dosmiley, $doxcode, $doimage, $dobr, $com_id);
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        if (empty($com_id)) {
            $com_id = $this->db->getInsertId();
        }
        $comment->assignVar('com_id', $com_id);
        return true;
    }

    /**
     * Delete a {@link Comment} from the database
     * 
     * @param   object  &$comment
     * 
     * @return  bool
     **/
    function delete(&$comment)
    {
        if (strtolower(get_class($comment)) != 'xoopscomment') {
            return false;
        }
        $sql = sprintf("DELETE FROM %s WHERE com_id = %u", $this->db->prefix('xoopscomments'), $comment->getVar('com_id'));
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }

    /**
     * Get some {@link Comment}s 
     * 
     * @param   object  $criteria
     * @param   bool    $id_as_key  Use IDs as keys into the array?
     * 
     * @return  array   Array of {@link Comment} objects
     **/
    function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT * FROM '.$this->db->prefix('xoopscomments');
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' '.$criteria->renderWhere();
            $sort = ($criteria->getSort() != '') ? $criteria->getSort() : 'com_id';
            $sql .= ' ORDER BY '.$sort.' '.$criteria->getOrder();
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }
        while ($myrow = $this->db->fetchArray($result)) {
            $comment = new Comment();
            $comment->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] =& $comment;
            } else {
                $ret[$myrow['com_id']] =& $comment;
            }
            unset($comment);
        }
        return $ret;
    }

    /**
     * Count Comments
     * 
     * @param   object  $criteria   {@link CriteriaElement} 
     * 
     * @return  int     Count
     **/
    function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('xoopscomments');
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result =& $this->db->query($sql)) {
            return 0;
        }
        list($count) = $this->db->fetchRow($result);
        return $count;
    }

    /**
     * Delete multiple comments
     * 
     * @param   object  $criteria   {@link CriteriaElement} 
     * 
     * @return  bool
     **/
    function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM '.$this->db->prefix('xoopscomments');
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }

   /**
     * Get a list of comments
     * 
     * @param   object  $criteria   {@link CriteriaElement} 
     * 
     * @return  array   Array of raw database records
     **/
    function &getList($criteria = null)
    {
        $comments =& $this->getObjects($criteria, true);
        $ret = array();
        foreach (array_keys($comments) as $i) {
            $ret[$i] = $comments[$i]->getVar('com_title');
        }
        return $ret;
    }

    /**
     * Retrieves comments for an item
     * 
     * @param   int     $module_id  Module ID
     * @param   int     $item_id    Item ID
     * @param   string  $order      Sort order
     * @param   int     $status     Status of the comment
     * @param   int     $limit      Max num of comments to retrieve
     * @param   int     $start      Start offset
     * 
     * @return  array   Array of {@link Comment} objects
     **/
    function &getByItemId($module_id, $item_id, $order = null, $status = null, $limit = null, $start = 0)
    {
        $criteria = new CriteriaCompo(new Criteria('com_modid', (int)$module_id));
        $criteria->add(new Criteria('com_itemid', (int)$item_id));
        if (isset($status)) {
            $criteria->add(new Criteria('com_status', (int)$status));
        }
        if (isset($order)) {
            $criteria->setOrder($order);
        }
        if (isset($limit)) {
            $criteria->setLimit($limit);
			$criteria->setStart($start);
        }
        return $this->getObjects($criteria);
    }

    /**
     * Gets total number of comments for an item
     * 
     * @param   int     $module_id  Module ID
     * @param   int     $item_id    Item ID
     * @param   int     $status     Status of the comment
     * 
     * @return  array   Array of {@link Comment} objects
     **/
    function &getCountByItemId($module_id, $item_id, $status = null)
    {
        $criteria = new CriteriaCompo(new Criteria('com_modid', (int)$module_id));
        $criteria->add(new Criteria('com_itemid', (int)$item_id));
        if (isset($status)) {
            $criteria->add(new Criteria('com_status', (int)$status));
        }
        return $this->getCount($criteria);
    }


    /**
     * Get the top {@link Comment}s 
     * 
     * @param   int     $module_id
     * @param   int     $item_id
     * @param   strint  $order
     * @param   int     $status
     * 
     * @return  array   Array of {@link Comment} objects
     **/
    function &getTopComments($module_id, $item_id, $order, $status = null)
    {
        $criteria = new CriteriaCompo(new Criteria('com_modid', (int)$module_id));
        $criteria->add(new Criteria('com_itemid', (int)$item_id));
        $criteria->add(new Criteria('com_pid', 0));
        if (isset($status)) {
            $criteria->add(new Criteria('com_status', (int)$status));
        }
        $criteria->setOrder($order);
        $ret =& $this->getObjects($criteria);
        return $ret;
    }

    /**
     * Retrieve a whole thread
     * 
     * @param   int     $comment_rootid
     * @param   int     $comment_id
     * @param   int     $status
     * 
     * @return  array   Array of {@link Comment} objects
     **/
    function &getThread($comment_rootid, $comment_id, $status = null)
    {
        $criteria = new CriteriaCompo(new Criteria('com_rootid', (int)$comment_rootid));
        $criteria->add(new Criteria('com_id', (int)$comment_id, '>='));
        if (isset($status)) {
            $criteria->add(new Criteria('com_status', (int)$status));
        }
        return $this->getObjects($criteria);
    }

    /**
     * Update
     * 
     * @param   object  &$comment       {@link Comment} object
     * @param   string  $field_name     Name of the field
     * @param   mixed   $field_value    Value to write
     * 
     * @return  bool
     **/
    function updateByField(&$comment, $field_name, $field_value)
    {
        $comment->unsetNew();
        $comment->setVar($field_name, $field_value);
        return $this->insert($comment);
    }

    /**
     * Delete all comments for one whole module
     * 
     * @param   int $module_id  ID of the module
     * @return  bool
     **/
    function deleteByModule($module_id)
    {
        return $this->deleteAll(new Criteria('com_modid', (int)$module_id));
    }

    /**
     * Change a value in multiple comments
     * 
     * @param   string  $fieldname  Name of the field
     * @param   string  $fieldvalue Value to write
     * @param   object  $criteria   {@link CriteriaElement} 
     * 
     * @return  bool
     **/
/*    
    function updateAll($fieldname, $fieldvalue, $criteria = null)
    {
        $set_clause = is_numeric($fieldvalue) ? $filedname.' = '.$fieldvalue : $filedname.' = '.$this->db->quoteString($fieldvalue);
        $sql = 'UPDATE '.$this->db->prefix('xoopscomments').' SET '.$set_clause;
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }
*/

	function getChildObjects(&$comment)
	{
		$ret=array();

		$table=$this->db->prefix("xoopscomments");
		$sql="SELECT * FROM ${table} WHERE com_pid=" . $comment->getVar("com_id") .
		      " AND com_id<>".$comment->getVar("com_id");
		$result=$this->db->query($sql);
		while($row=$this->db->fetchArray($result)) {
			$comment=new Comment();
			$comment->assignVars($row);
			$ret[]=&$comment;
			unset($comment);
		}
		
		return $ret;
	}
	
	function deleteWithChild(&$comment)
	{
		foreach($this->getChildObjects($comment) as $child) {
			$this->deleteWithChild($child);
		}
		$this->delete($comment);
		
		return true;	// TODO
	}
}
