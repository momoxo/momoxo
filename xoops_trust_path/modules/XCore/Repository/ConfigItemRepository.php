<?php


namespace XCore\Repository;

/**
* XOOPS configuration handler class.  
* 
* This class is responsible for providing data access mechanisms to the data source 
* of XOOPS configuration class objects.
*
* @author       Kazumi Ono <onokazu@xoops.org>
* @copyright    copyright (c) 2000-2003 XOOPS.org
*/
use XCore\Repository\ObjectRepository;
use XCore\Database\CriteriaElement;
use XCore\Entity\ConfigItem;
use XCore\Database\Criteria;

class ConfigItemRepository extends ObjectRepository
{

    /**
     * Create a new {@link ConfigItem}
     * 
     * @see     ConfigItem
     * @param	bool    $isNew  Flag the config as "new"?
     * @return	object  reference to the new config
     */
    function &create($isNew = true)
    {
        $config =new ConfigItem();
        if ($isNew) {
            $config->setNew();
        }
        return $config;
    }

    /**
     * Load a config from the database
     * 
     * @param	int $id ID of the config
     * @return	object  reference to the config, FALSE on fail
     */
    function &get($id)
    {
        $ret = false;
        $id = (int)$id;
        if ($id > 0) {
			$db = &$this->db;
            $sql = 'SELECT * FROM '.$db->prefix('config').' WHERE conf_id='.$id;
            if ($result = $db->query($sql)) {
                $numrows = $db->getRowsNum($result);
                if ($numrows == 1) {
                    $myrow = $db->fetchArray($result);
                        $config =new ConfigItem();
                    $config->assignVars($myrow);
                        $ret =& $config;
                }
            }
        }
        return $ret;
    }

    /**
     * Write a config to the database
     * 
     * @param	object  &$config    {@link ConfigItem} object
     * @return  mixed   FALSE on fail.
     */
    function insert(&$config)
    {
        if (strtolower(get_class($config)) != 'xoopsconfigitem') {
            return false;
        }
        if (!$config->isDirty()) {
            return true;
        }
        if (!$config->cleanVars()) {
            return false;
        }
        foreach ($config->cleanVars as $k => $v) {
            ${$k} = $v;
        }
		$db = &$this->db;
        if ($config->isNew()) {
            $conf_id = $db->genId('config_conf_id_seq');
            $sql = sprintf('INSERT INTO %s (conf_id, conf_modid, conf_catid, conf_name, conf_title, conf_value, conf_desc, conf_formtype, conf_valuetype, conf_order) VALUES (%u, %u, %u, %s, %s, %s, %s, %s, %s, %u)', $db->prefix('config'), $conf_id, $conf_modid, $conf_catid, $db->quoteString($conf_name), $db->quoteString($conf_title), $db->quoteString($conf_value), $db->quoteString($conf_desc), $db->quoteString($conf_formtype), $db->quoteString($conf_valuetype), $conf_order);
        } else {
            $sql = sprintf('UPDATE %s SET conf_modid = %u, conf_catid = %u, conf_name = %s, conf_title = %s, conf_value = %s, conf_desc = %s, conf_formtype = %s, conf_valuetype = %s, conf_order = %u WHERE conf_id = %u', $db->prefix('config'), $conf_modid, $conf_catid, $db->quoteString($conf_name), $db->quoteString($conf_title), $db->quoteString($conf_value), $db->quoteString($conf_desc), $db->quoteString($conf_formtype), $db->quoteString($conf_valuetype), $conf_order, $conf_id);
        }
        if (!$result = $db->query($sql)) {
            return false;
        }
        if (empty($conf_id)) {
            $conf_id = $db->getInsertId();
        }
        $config->assignVar('conf_id', $conf_id);
        return true;
    }

    /**
     * Delete a config from the database
     * 
     * @param	object  &$config    Config to delete
     * @return	bool    Successful?
     */
    function delete(&$config)
    {
        if (strtolower(get_class($config)) != 'xoopsconfigitem') {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE conf_id = %u', $this->db->prefix('config'), $config->getVar('conf_id'));
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }

    /**
     * Get configs from the database
     * 
     * @param	object  $criteria   {@link CriteriaElement}
     * @param	bool    $id_as_key  return the config's id as key?
     * @return	array   Array of {@link ConfigItem} objects
     */
    function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret = array();
        $limit = $start = 0;
        $db = $this->db;
        $sql = 'SELECT * FROM '.$db->prefix('config');
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' '.$criteria->renderWhere();
            $sql .= ' ORDER BY conf_order ASC';
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }
        while ($myrow = $db->fetchArray($result)) {
            $config =new ConfigItem();
            $config->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] =& $config;
            } else {
                $ret[$myrow['conf_id']] =& $config;
            }
            unset($config);
        }
        return $ret;
    }

    /**
     * Count configs
     * 
     * @param	object  $criteria   {@link CriteriaElement} 
     * @return	int     Count of configs matching $criteria
     */
    function getCount($criteria = null)
    {
        $limit = $start = 0;
		$db = &$this->db;
        $sql = 'SELECT * FROM '.$db->prefix('config');
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' '.$criteria->renderWhere();
        }
        $result = $db->query($sql);
        if (!$result) {
            return false;
        }
        list($count) = $db->fetchRow($result);
        return $count;
    }
}
