<?php

/**
* XOOPS membership handler class. (Singleton)
* 
* This class is responsible for providing data access mechanisms to the data source 
* of XOOPS group membership class objects.
*
* @author Kazumi Ono <onokazu@xoops.org>
* @copyright copyright (c) 2000-2003 XOOPS.org
* @package kernel
*/
class XoopsMembershipHandler extends XoopsObjectHandler
{

    /**
     * create a new membership
     * 
     * @param bool $isNew should the new object be set to "new"?
     * @return object XoopsMembership
     */
    function &create($isNew = true)
    {
        $mship =new XoopsMembership();
        if ($isNew) {
            $mship->setNew();
        }
        return $mship;
    }

    /**
     * retrieve a membership
     * 
     * @param int $id ID of the membership to get
     * @return mixed reference to the object if successful, else FALSE
     */
    function &get($id)
    {
        $ret = false;
        if ((int)$id > 0) {
            $db = &$this->db;
            $sql = 'SELECT * FROM '.$db->prefix('groups_users_link').' WHERE linkid='.$id;
            if ($result = $db->query($sql)) {
                $numrows = $db->getRowsNum($result);
                if ($numrows == 1) {
                        $mship =new XoopsMembership();
                    $mship->assignVars($db->fetchArray($result));
                        $ret =& $mship;
                }
            }
        }
        return $ret;
    }

    /**
     * inserts a membership in the database
     * 
     * @param object $mship reference to the membership object
     * @return bool TRUE if already in DB or successful, FALSE if failed
     */
    function insert(&$mship)
    {
        if (strtolower(get_class($mship)) != 'xoopsmembership') {
            return false;
        }
        if (!$mship->isDirty()) {
            return true;
        }
        if (!$mship->cleanVars()) {
            return false;
        }
        foreach ($mship->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        $db = &$this->db;
        if ($mship->isNew()) {
            $linkid = $db->genId('groups_users_link_linkid_seq');
            $sql = sprintf("INSERT INTO %s (linkid, groupid, uid) VALUES (%u, %u, %u)", $db->prefix('groups_users_link'), $linkid, $groupid, $uid);
        } else {
            $sql = sprintf("UPDATE %s SET groupid = %u, uid = %u WHERE linkid = %u", $db->prefix('groups_users_link'), $groupid, $uid, $linkid);
        }
        if (!$result = $db->query($sql)) return false;
        if (empty($linkid)) $linkid = $this->db->getInsertId();
        $mship->assignVar('linkid', $linkid);
        return true;
    }

    /**
     * delete a membership from the database
     * 
     * @param object $mship reference to the membership object
     * @return bool FALSE if failed
     */
    function delete(&$mship)
    {
        if (strtolower(get_class($mship)) != 'xoopsmembership') {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE linkid = %u', $this->db->prefix('groups_users_link'), $groupm->getVar('linkid'));
        if (!$result = $this->db->query($sql)) return false;
        return true;
    }

    /**
     * retrieve memberships from the database
     * 
     * @param object $criteria {@link CriteriaElement} conditions to meet
     * @param bool $id_as_key should the ID be used as the array's key?
     * @return array array of references
     */
    function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret = array();
        $limit = $start = 0;
        $db = &$this->db;
        $sql = 'SELECT * FROM '.$db->prefix('groups_users_link');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }
        while ($myrow = $db->fetchArray($result)) {
            $mship = new XoopsMembership();
            $mship->assignVars($myrow);
			if (!$id_as_key) {
            	$ret[] =& $mship;
			} else {
				$ret[$myrow['linkid']] =& $mship;
			}
            unset($mship);
        }
        return $ret;
    }

    /**
     * count how many memberships meet the conditions
     * 
     * @param object $criteria {@link CriteriaElement} conditions to meet
     * @return int
     */
    function getCount($criteria = null)
    {
        $db = &$this->db;
        $sql = 'SELECT COUNT(*) FROM '.$db->prefix('groups_users_link');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        }
        $result = $db->query($sql);
        if (!$result) {
            return 0;
        }
        list($count) = $db->fetchRow($result);
        return $count;
    }

    /**
     * delete all memberships meeting the conditions
     * 
     * @param object $criteria {@link CriteriaElement} with conditions to meet
     * @return bool
     */
    function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM '.$this->db->prefix('groups_users_link');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) return false;
        return true;
    }

    /**
     * retrieve groups for a user
     * 
     * @param int $uid ID of the user
     * @param bool $asobject should the groups be returned as {@link XoopsGroup}
     * objects? FALSE returns associative array.
     * @return array array of groups the user belongs to
     */
    function &getGroupsByUser($uid)
    {
        $ret = array();
        $db = &$this->db;
        $sql = 'SELECT groupid FROM '.$db->prefix('groups_users_link').' WHERE uid='.(int)$uid;
        $result = $db->query($sql);
        if (!$result) return $ret;
        while (list($groupid) = $db->fetchRow($result)) {
            $ret[] = $groupid;
        }
        return $ret;
    }

    /**
     * retrieve users belonging to a group
     * 
     * @param int $groupid ID of the group
     * @param bool $asobject return users as {@link XoopsUser} objects?
     * FALSE will return arrays
     * @param int $limit number of entries to return
     * @param int $start offset of first entry to return
     * @return array array of users belonging to the group
     */
    function &getUsersByGroup($groupid, $limit=0, $start=0)
    {
        $ret = array();
        $db = &$this->db;
        $sql = 'SELECT uid FROM ' . $db->prefix('groups_users_link') . ' WHERE groupid='.(int)$groupid;

        $result = $db->query($sql, $limit, $start);
        if (!$result) return $ret;
        while (list($uid) = $db->fetchRow($result)) {
            $ret[] = $uid;
        }
        return $ret;
    }

    /**
     * @see getUsersByGroup
     */
    function &getUsersByNoGroup($groupid, $limit=0, $start=0)
    {
        $ret = array();

        $groupid = (int)$groupid;
        $db = &$this->db;
        $usersTable = $db->prefix('users');
        $linkTable = $db->prefix('groups_users_link');

        $sql = "SELECT u.uid FROM ${usersTable} u LEFT JOIN ${linkTable} g ON u.uid=g.uid," .
                "${usersTable} u2 LEFT JOIN ${linkTable} g2 ON u2.uid=g2.uid AND g2.groupid=${groupid} " .
                "WHERE (g.groupid != ${groupid} OR g.groupid IS NULL) " .
                "AND (g2.groupid = ${groupid} OR g2.groupid IS NULL) " .
                "AND u.uid = u2.uid AND g2.uid IS NULL GROUP BY u.uid";

        $result = $db->query($sql, $limit, $start);
        if (!$result) return $ret;
        while (list($uid) = $db->fetchRow($result)) {
            $ret[] = $uid;
        }
        return $ret;
    }
}
