<?php


namespace XCore\Repository;

/**
* XOOPS group handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS group class objects.
*
* @author Kazumi Ono <onokazu@xoops.org>
* @copyright copyright (c) 2000-2003 XOOPS.org
* @package kernel
* @subpackage member
*/
use XCore\Repository\ObjectRepository;
use XCore\Database\CriteriaElement;
use XCore\Database\Criteria;
use XCore\Entity\Group;

class GroupRepository extends ObjectRepository
{

    /**
     * create a new {@link Group} object
     * 
     * @param bool $isNew mark the new object as "new"?
     * @return object Group reference to the new object
     * 
     */
    function &create($isNew = true)
    {
        $group =new Group();
        if ($isNew) {
            $group->setNew();
        }

        $group->setVar('group_type', 'User');

        return $group;
    }

    /**
     * retrieve a specific group
     * 
     * @param int $id ID of the group to get
     * @return object Group reference to the group object, FALSE if failed
     */
    function &get($id)
    {
        $ret = false;
        if ((int)$id > 0) {
            $db = &$this->db;
            $sql = 'SELECT * FROM '.$db->prefix('groups').' WHERE groupid='.$id;
            if ($result = $db->query($sql)) {
                $numrows = $db->getRowsNum($result);
                if ($numrows == 1) {
                    $group = new Group();
                    $group->assignVars($db->fetchArray($result));
                        $ret =& $group;
                }
            }
        }
        return $ret;
    }

    /**
     * insert a group into the database
     * 
     * @param object reference to the group object
     * @return mixed ID of the group if inserted, FALSE if failed, TRUE if already present and unchanged.
     */
    function insert(&$group)
    {
        if (strtolower(get_class($group)) != 'xoopsgroup') {
            return false;
        }
        if (!$group->isDirty()) {
            return true;
        }
        if (!$group->cleanVars()) {
            return false;
        }
        foreach ($group->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        $db = &$this->db;
        if ($group->isNew()) {
            $groupid = $db->genId('group_groupid_seq');
            $sql = sprintf('INSERT INTO %s (groupid, name, description, group_type) VALUES (%u, %s, %s, %s)', $db->prefix('groups'), $groupid, $db->quoteString($name), $db->quoteString($description), $db->quoteString($group_type));
        } else {
            $sql = sprintf("UPDATE %s SET name = %s, description = %s, group_type = %s WHERE groupid = %u", $db->prefix('groups'), $db->quoteString($name), $db->quoteString($description), $db->quoteString($group_type), $groupid);
        }
        if (!$result = $db->query($sql)) return false;
        if (empty($groupid)) $groupid = $db->getInsertId();
        $group->assignVar('groupid', $groupid);
        return true;
    }

    /**
     * remove a group from the database
     * 
     * @param object $group reference to the group to be removed
     * @return bool FALSE if failed
     */
    function delete(&$group)
    {
        if (strtolower(get_class($group)) != 'xoopsgroup') return false;
        $sql = sprintf('DELETE FROM %s WHERE groupid = %u', $this->db->prefix('groups'), $group->getVar('groupid'));
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }

    /**
     * retrieve groups from the database
     * 
     * @param object $criteria {@link CriteriaElement} with conditions for the groups
     * @param bool $id_as_key should the groups' IDs be used as keys for the associative array?
     * @return mixed Array of groups
     */
    function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret = array();
        $limit = $start = 0;
        $db = &$this->db;
        $sql = 'SELECT * FROM '.$db->prefix('groups');
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' '.$criteria->renderWhere();
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }
        while ($myrow = $db->fetchArray($result)) {
            $group =new Group();
            $group->assignVars($myrow);
			if (!$id_as_key) {
            	$ret[] =& $group;
			} else {
				$ret[$myrow['groupid']] =& $group;
			}
            unset($group);
        }
        return $ret;
    }
}
