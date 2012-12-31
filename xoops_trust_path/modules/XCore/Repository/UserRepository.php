<?php

namespace XCore\Repository;

use XCore\Entity\User;
use XCore\Repository\ObjectRepository;
use XCore\Repository\ConfigRepository;
use XCore\Database\CriteriaElement;
use XCore\Database\Criteria;

/**
* XOOPS user handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Kazumi Ono <onokazu@xoops.org>
* @copyright copyright (c) 2000-2003 XOOPS.org
* @package kernel
*/
class UserRepository extends ObjectRepository
{

    /**
     * create a new user
     *
     * @param  bool   $isNew flag the new objects as "new"?
     * @return object User
     */
    function &create($isNew = true)
    {
        $user =new User();
        if ($isNew) {
            $user->setNew();
        }

        return $user;
    }

    /**
     * retrieve a user
     *
     * @param  int   $id UID of the user
     * @return mixed reference to the {@link User} object, FALSE if failed
     */
    function &get($id)
    {
        $ret = false;
        if ((int) $id > 0) {
            $sql = 'SELECT * FROM '.$this->db->prefix('users').' WHERE uid='.$id;
            if ($result = $this->db->query($sql)) {
                $numrows = $this->db->getRowsNum($result);
                if ($numrows == 1) {
                        $user =new User();
                    $user->assignVars($this->db->fetchArray($result));
                        $ret =& $user;
                }
            }
        }

        return $ret;
    }

    /**
     * insert a new user in the database
     *
     * @param  object $user  reference to the {@link User} object
     * @param  bool   $force
     * @return bool   FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(&$user, $force = false)
    {
        if ( ($user instanceof User) === false ) {
            return false;
        }
        if (!$user->isDirty()) {
            return true;
        }
        if (!$user->cleanVars()) {
            return false;
        }
        foreach ($user->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        // RMV-NOTIFY
        // Added two fields, notify_method, notify_mode
        if ($user->isNew()) {
            /** @var $config ConfigRepository */
            $config = xoops_gethandler('config');
            $options = $config->getConfigs(new Criteria('conf_name', 'notify_method'));
            if (isset($options) and (count($options) == 1)) {
                $notify_method = $options[0]->getvar('conf_value');
            }
            $uid = $this->db->genId('users_uid_seq');
            $sql = sprintf("INSERT INTO %s (uid, uname, name, email, url, user_avatar, user_regdate, user_icq, user_from, user_sig, user_viewemail, actkey, user_aim, user_yim, user_msnm, pass, posts, attachsig, rank, level, theme, timezone_offset, last_login, umode, uorder, notify_method, notify_mode, user_occ, bio, user_intrest, user_mailok) VALUES (%u, %s, %s, %s, %s, %s, %u, %s, %s, %s, %u, %s, %s, %s, %s, %s, %u, %u, %u, %u, %s, %.2f, %u, %s, %u, %u, %u, %s, %s, %s, %u)", $this->db->prefix('users'), $uid, $this->db->quoteString($uname), $this->db->quoteString($name), $this->db->quoteString($email), $this->db->quoteString($url), $this->db->quoteString($user_avatar), time(), $this->db->quoteString($user_icq), $this->db->quoteString($user_from), $this->db->quoteString($user_sig), $user_viewemail, $this->db->quoteString($actkey), $this->db->quoteString($user_aim), $this->db->quoteString($user_yim), $this->db->quoteString($user_msnm), $this->db->quoteString($pass), $posts, $attachsig, $rank, $level, $this->db->quoteString($theme), $timezone_offset, 0, $this->db->quoteString($umode), $uorder, $notify_method, $notify_mode, $this->db->quoteString($user_occ), $this->db->quoteString($bio), $this->db->quoteString($user_intrest), $user_mailok);
        } else {
            $sql = sprintf("UPDATE %s SET uname = %s, name = %s, email = %s, url = %s, user_avatar = %s, user_icq = %s, user_from = %s, user_sig = %s, user_viewemail = %u, user_aim = %s, user_yim = %s, user_msnm = %s, posts = %d,  pass = %s, attachsig = %u, rank = %u, level= %u, theme = %s, timezone_offset = %.2f, umode = %s, last_login = %u, uorder = %u, notify_method = %u, notify_mode = %u, user_occ = %s, bio = %s, user_intrest = %s, user_mailok = %u WHERE uid = %u", $this->db->prefix('users'), $this->db->quoteString($uname), $this->db->quoteString($name), $this->db->quoteString($email), $this->db->quoteString($url), $this->db->quoteString($user_avatar), $this->db->quoteString($user_icq), $this->db->quoteString($user_from), $this->db->quoteString($user_sig), $user_viewemail, $this->db->quoteString($user_aim), $this->db->quoteString($user_yim), $this->db->quoteString($user_msnm), $posts, $this->db->quoteString($pass), $attachsig, $rank, $level, $this->db->quoteString($theme), $timezone_offset, $this->db->quoteString($umode), $last_login, $uorder, $notify_method, $notify_mode, $this->db->quoteString($user_occ), $this->db->quoteString($bio), $this->db->quoteString($user_intrest), $user_mailok, $uid);
        }
        if (false != $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }
        if (empty($uid)) {
            $uid = $this->db->getInsertId();
        }
        $user->assignVar('uid', $uid);

        return true;
    }

    /**
     * delete a user from the database
     *
     * @param  object $user  reference to the user to delete
     * @param  bool   $force
     * @return bool   FALSE if failed.
     */
    public function delete(&$user, $force = false)
    {
        if ( ($user instanceof User) === false ) {
            return false;
        }
        $sql = sprintf("DELETE FROM %s WHERE uid = %u", $this->db->prefix("users"), $user->getVar('uid'));
        if (false != $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * retrieve users from the database
     *
     * @param  object $criteria  {@link CriteriaElement} conditions to be met
     * @param  bool   $id_as_key use the UID as key for the array?
     * @return array  array of {@link User} objects
     */
    function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT * FROM '.$this->db->prefix('users');
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' '.$criteria->renderWhere();
            if ($criteria->getSort() != '') {
                $sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }
        while ($myrow = $this->db->fetchArray($result)) {
            $user =new User();
            $user->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] =& $user;
            } else {
                $ret[$myrow['uid']] =& $user;
            }
            unset($user);
        }

        return $ret;
    }

    /**
     This method is called from pmlite.php. Wmm..
     Type:expand (no using criteria).
     @author minahito
     */
    function &getObjectsByLevel($level=0)
    {
        $ret=array();
        $level=(int) $level;
        $result = $this->db->query("SELECT * FROM ".$this->db->prefix("users")." WHERE level > $level ORDER BY uname");
        if(!$result)

            return $ret;

        while ($myrow=$this->db->fetchArray($result)) {
            $user=new User();
            $user->assignVars($myrow);
            $ret[]=&$user;
            unset($user);
        }

        return $ret;
    }

    /**
     * count users matching a condition
     *
     * @param  object $criteria {@link CriteriaElement} to match
     * @return int    count of users
     */
    public function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('users');
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' '.$criteria->renderWhere();
        }
        $result = $this->db->query($sql);
        if (!$result) {
            return 0;
        }
        list($count) = $this->db->fetchRow($result);

        return $count;
    }

    /**
     * delete users matching a set of conditions
     *
     * @param  object $criteria {@link CriteriaElement}
     * @return bool   FALSE if deletion failed
     */
    public function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM '.$this->db->prefix('users');
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }

        return true;
    }

    /**
     * Change a value for users with a certain criteria
     *
     * @param string $fieldname  Name of the field
     * @param string $fieldvalue Value to write
     * @param object $criteria   {@link CriteriaElement}
     *
     * @return bool
     **/
    public function updateAll($fieldname, $fieldvalue, $criteria = null)
    {
        $set_clause = is_numeric($fieldvalue) ? $fieldname.' = '.$fieldvalue : $fieldname.' = '.$this->db->quoteString($fieldvalue);
        $sql = 'UPDATE '.$this->db->prefix('users').' SET '.$set_clause;
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }

        return true;
    }
}
