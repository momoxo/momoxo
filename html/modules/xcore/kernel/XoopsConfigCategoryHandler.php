<?php

/**
 * XOOPS configuration category handler class.  
 * 
 * This class is responsible for providing data access mechanisms to the data source 
 * of XOOPS configuration category class objects.
 *
 * @author  Kazumi Ono <onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 * 
 * @package     kernel
 * @subpackage  config
 */
class XoopsConfigCategoryHandler extends XoopsObjectHandler
{

    /**
     * Create a new category
     * 
     * @param	bool    $isNew  Flag the new object as "new"?
     * 
     * @return	object  New {@link XoopsConfigCategory} 
     */
    function &create($isNew = true)
    {
        $confcat =new XoopsConfigCategory();
        if ($isNew) {
            $confcat->setNew();
        }
        return $confcat;
    }

    /**
     * Retrieve a {@link XoopsConfigCategory} 
     * 
     * @param	int $id ID
     * 
     * @return	object  {@link XoopsConfigCategory}, FALSE on fail
     */
    function &get($id)
    {
        $ret = false;
        $id = (int)$id;
        if ($id > 0) {
            $sql = 'SELECT * FROM '.$this->db->prefix('configcategory').' WHERE confcat_id='.$id;
            if ($result = $this->db->query($sql)) {
                $numrows = $this->db->getRowsNum($result);
                if ($numrows == 1) {
                        $confcat =new XoopsConfigCategory();
                    $confcat->assignVars($this->db->fetchArray($result), false);
                        $ret =& $confcat;
                }
            }
        }
        return $ret;
    }

    /**
     * Store a {@link XoopsConfigCategory}
     * 
     * @param	object   &$confcat  {@link XoopsConfigCategory}
     * 
     * @return	bool    TRUE on success
     */
    function insert(&$confcat)
    {
        if (strtolower(get_class($confcat)) != 'xoopsconfigcategory') {
            return false;
        }
        if (!$confcat->isDirty()) {
            return true;
        }
        if (!$confcat->cleanVars()) {
            return false;
        }
        foreach ($confcat->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        if ($confcat->isNew()) {
            $confcat_id = $this->db->genId('configcategory_confcat_id_seq');
            $sql = sprintf("INSERT INTO %s (confcat_id, confcat_name, confcat_order) VALUES (%u, %s, %u)", $this->db->prefix('configcategory'), $confcat_id, $this->db->quoteString($confcat_name), $confcat_order);
        } else {
            $sql = sprintf("UPDATE %s SET confcat_name = %s, confcat_order = %u WHERE confcat_id = %u", $this->db->prefix('configcategory'), $this->db->quoteString($confcat_name), $confcat_order, $confcat_id);
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        if (empty($confcat_id)) {
            $confcat_id = $this->db->getInsertId();
        }
        $confcat->assignVar('confcat_id', $confcat_id);
        return $confcat_id;
    }

    /**
     * Delelete a {@link XoopsConfigCategory}
     * 
     * @param	object  &$confcat   {@link XoopsConfigCategory}
     * 
     * @return	bool    TRUE on success
     */
    function delete(&$confcat)
    {
        if (strtolower(get_class($confcat)) != 'xoopsconfigcategory') {
            return false;
        }
        $sql = sprintf("DELETE FROM %s WHERE confcat_id = %u", $this->db->prefix('configcategory'), $confcat->getVar('confcat_id'));
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }

    /**
     * Get some {@link XoopsConfigCategory}s
     * 
     * @param	object  $criteria   {@link CriteriaElement} 
     * @param	bool    $id_as_key  Use the IDs as keys to the array?
     * 
     * @return	array   Array of {@link XoopsConfigCategory}s
     */
    function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT * FROM '.$this->db->prefix('configcategory');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
            $sort = !in_array($criteria->getSort(), array('confcat_id', 'confcat_name', 'confcat_order')) ? 'confcat_order' : $criteria->getSort();
            $sql .= ' ORDER BY '.$sort.' '.$criteria->getOrder();
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }
        while ($myrow = $this->db->fetchArray($result)) {
            $confcat =new XoopsConfigCategory();
            $confcat->assignVars($myrow, false);
            if (!$id_as_key) {
                $ret[] =& $confcat;
            } else {
                $ret[$myrow['confcat_id']] =& $confcat;
            }
            unset($confcat);
        }
        return $ret;
    }
}
