<?php

/**
 * XOOPS configuration option handler class.  
 * This class is responsible for providing data access mechanisms to the data source 
 * of XOOPS configuration option class objects.
 *
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 * @author  Kazumi Ono <onokazu@xoops.org>
 * 
 * @package     kernel
 * @subpackage  config
*/
class XoopsConfigOptionHandler extends XoopsObjectHandler
{

    /**
     * Create a new option
     * 
     * @param	bool    $isNew  Flag the option as "new"?
     * 
     * @return	object  {@link XoopsConfigOption} 
     */
    function &create($isNew = true)
    {
        $confoption =new XoopsConfigOption();
        if ($isNew) {
            $confoption->setNew();
        }
        return $confoption;
    }

    /**
     * Get an option from the database
     * 
     * @param	int $id ID of the option
     * 
     * @return	object  reference to the {@link XoopsConfigOption}, FALSE on fail
     */
    function &get($id)
    {
        $ret = false;
        $id = (int)$id;
        if ($id > 0) {
            $sql = 'SELECT * FROM '.$this->db->prefix('configoption').' WHERE confop_id='.$id;
            if ($result = $this->db->query($sql)) {
                $numrows = $this->db->getRowsNum($result);
                if ($numrows == 1) {
                        $confoption =new XoopsConfigOption();
                    $confoption->assignVars($this->db->fetchArray($result));
                        $ret =& $confoption;
                }
            }
        }
        return $ret;
    }

    /**
     * Insert a new option in the database
     * 
     * @param	object  &$confoption    reference to a {@link XoopsConfigOption} 
     * @return	bool    TRUE if successfull.
     */
    function insert(&$confoption)
    {
        if (strtolower(get_class($confoption)) != 'xoopsconfigoption') {
            return false;
        }
        if (!$confoption->isDirty()) {
            return true;
        }
        if (!$confoption->cleanVars()) {
            return false;
        }
        foreach ($confoption->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        if ($confoption->isNew()) {
            $confop_id = $this->db->genId('configoption_confop_id_seq');
            $sql = sprintf('INSERT INTO %s (confop_id, confop_name, confop_value, conf_id) VALUES (%u, %s, %s, %u)', $this->db->prefix('configoption'), $confop_id, $this->db->quoteString($confop_name), $this->db->quoteString($confop_value), $conf_id);
        } else {
            $sql = sprintf('UPDATE %s SET confop_name = %s, confop_value = %s WHERE confop_id = %u', $this->db->prefix('configoption'), $this->db->quoteString($confop_name), $this->db->quoteString($confop_value), $confop_id);
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        if (empty($confop_id)) {
            $confop_id = $this->db->getInsertId();
        }
        $confoption->assignVar('confop_id', $confop_id);
        return $confop_id;
    }

    /**
     * Delete an option
     * 
     * @param	object  &$confoption    reference to a {@link XoopsConfigOption} 
     * @return	bool    TRUE if successful
     */
    function delete(&$confoption)
    {
        if (strtolower(get_class($confoption)) != 'xoopsconfigoption') {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE confop_id = %u', $this->db->prefix('configoption'), $confoption->getVar('confop_id', 'n'));
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }

    /**
     * Get some {@link XoopsConfigOption}s 
     * 
     * @param	object  $criteria   {@link CriteriaElement} 
     * @param	bool    $id_as_key  Use the IDs as array-keys?
     * 
     * @return	array   Array of {@link XoopsConfigOption}s 
     */
    function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT * FROM '.$this->db->prefix('configoption');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere().' ORDER BY confop_id '.$criteria->getOrder();
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }
        while ($myrow = $this->db->fetchArray($result)) {
            $confoption =new XoopsConfigOption();
            $confoption->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] =& $confoption;
            } else {
                $ret[$myrow['confop_id']] =& $confoption;
            }
            unset($confoption);
        }
        return $ret;
    }
}
