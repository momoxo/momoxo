<?php

/**
 * XOOPS module handler class.
 *
 * This class is responsible for providing data access mechanisms to the data source
 * of XOOPS module class objects.
 *
 * @package 	kernel
 *
 * @author		Kazumi Ono	<onokazu@xoops.org>
 * @copyright	(c) 2000-2003 The Xoops Project - www.xoops.org
 */
class XoopsModuleHandler extends XoopsObjectHandler
{
	var $_tmp;	
	
	/**
	 * holds an array of cached module references, indexed by module id/dirname
	 *
	 * @var    array
	 * @access private
	 */
	var $_cachedModule_mid = array();

	/**
	 * holds an array of cached module references, indexed by module dirname
	 *
	 * @var    array
	 * @access private
	 */
	var $_cachedModule_dirname = array();

	/**
	 * Create a new {@link XoopsModule} object
	 *
	 * @param	boolean 	$isNew	 Flag the new object as "new"
	 * @return	object
	 **/
	function &create($isNew = true)
	{
		$module =new XoopsModule();
		if ($isNew) {
			$module->setNew();
		}
		return $module;
	}

	/**
	 * Load a module from the database
	 *
	 * @param	int 	$id 	ID of the module
	 *
	 * @return	object	FALSE on fail
	 */
	function &get($id)
	{
		$ret = false;
		$id = (int)$id;
		if ($id > 0) {
			if (!empty($this->_cachedModule_mid[$id])) {
				return $this->_cachedModule_mid[$id];
			} else {
				$sql = 'SELECT * FROM '.$this->db->prefix('modules').' WHERE mid = '.$id;
				if ($result = $this->db->query($sql)) {
					$numrows = $this->db->getRowsNum($result);
					if ($numrows == 1) {
						$module =new XoopsModule();
						$myrow = $this->db->fetchArray($result);
						$module->assignVars($myrow);
						$this->_cachedModule_mid[$id] =& $module;
						$this->_cachedModule_dirname[$module->getVar('dirname')] =& $module;
						$ret =& $module;
					}
				}
			}
		}
		return $ret;
	}

	/**
	 * Load a module by its dirname
	 *
	 * @param	string	$dirname
	 *
	 * @return	object	FALSE on fail
	 */
	function &getByDirname($dirname)
	{
		$dirname =	trim($dirname);
		if (isset($this->_cachedModule_dirname[$dirname])) {
			return $this->_cachedModule_dirname[$dirname];
		}

        $this->_cachedModule_dirname[$dirname] = false;

        $db = $this->db;
        $sql = "SELECT * FROM ".$db->prefix('modules');
        if ($result = $db->query($sql)) {
            while ($myrow = $db->fetchArray($result)) {
                 $module = new XoopsModule();
                 $module->assignVars($myrow);
                 $this->_cachedModule_dirname[$myrow['dirname']] =& $module;
                 $this->_cachedModule_mid[$myrow['mid']] =& $module;
                 unset($module);
            }
        }
        return $this->_cachedModule_dirname[$dirname];
	}

	/**
	 * Write a module to the database
	 *
	 * @remark This method unsets cache of the module, and re-contruct the cache.
	 *		   But this mechanism may break the reference to the previous cache....
	 *		   Maybe that's no problem. But, we should notice it. 
	 * @param	object	&$module reference to a {@link XoopsModule}
	 * @return	bool
	 **/
	function insert(&$module)
	{
		if (strtolower(get_class($module)) != 'xoopsmodule') {
			return false;
		}
		
		if (!$module->isDirty()) {
			return true;
		}
		if (!$module->cleanVars()) {
			return false;
		}
		foreach ($module->cleanVars as $k => $v) {
			${$k} = $v;
		}
		if ($module->isNew()) {
			if (empty($mid)) { //Memo: if system module, mid might be set to 1
				$mid = $this->db->genId('modules_mid_seq');
			}

			$data = array(
				'%table%'          => $this->db->prefix('modules'),
				':mid'             => $mid,
				':name'            => $this->db->quoteString($name),
				':version'         => $version,
				':last_update'     => time(),
				':weight'          => $weight,
				':isactive'        => 1, // TODO >> magic number
				':issystem'        => $issystem,
				':dirname'         => $this->db->quoteString($dirname),
				':trust_dirname'   => $this->db->quoteString($trust_dirname),
				':role'            => $this->db->quoteString($role),
				':hasmain'         => $hasmain,
				':hasadmin'        => $hasadmin,
				':hassearch'       => $hassearch,
				':hasconfig'       => $hasconfig,
				':hascomments'     => $hascomments,
				':hasnotification' => $hasnotification,
			);
			$sql = "
				INSERT INTO %table% (
					mid, name, version, last_update, weight, isactive,
					issystem, dirname, trust_dirname, role, hasmain,
					hasadmin, hassearch, hasconfig, hascomments, hasnotification
				) VALUES (
					:mid, :name, :version, :last_update, :weight, :isactive,
					:issystem, :dirname, :trust_dirname, :role, :hasmain,
					:hasadmin, :hassearch, :hasconfig, :hascomments, :hasnotification
				)";
			$sql = str_replace(array_keys($data), array_values($data), $sql);
        } else {
            $sql = sprintf("UPDATE %s SET name = %s, dirname = %s, trust_dirname = %s, role = %s, version = %u, last_update = %u, weight = %u, isactive = %u, issystem = %u, hasmain = %u, hasadmin = %u, hassearch = %u, hasconfig = %u, hascomments = %u, hasnotification = %u WHERE mid = %u", $this->db->prefix('modules'), $this->db->quoteString($name), $this->db->quoteString($dirname), $this->db->quoteString($trust_dirname), $this->db->quoteString($role), $version, time(), $weight, $isactive, $issystem, $hasmain, $hasadmin, $hassearch, $hasconfig, $hascomments, $hasnotification, $mid);
		}
		if (!$result = $this->db->query($sql)) {
			return false;
		}
		$module->unsetNew();
		if (empty($mid)) {
			$mid = $this->db->getInsertId();
		}
		$module->assignVar('mid', $mid);
		if (!empty($this->_cachedModule_dirname[$dirname])) {
			unset ($this->_cachedModule_dirname[$dirname]);
		}
		if (!empty($this->_cachedModule_mid[$mid])) {
			unset ($this->_cachedModule_mid[$mid]);
		}
		
		$this->_cachedModule_dirname[$dirname] = $module;
		$this->_cachedModule_mid[$mid] =& $this->_cachedModule_dirname[$dirname];

		if (class_exists('Xcore_AdminSideMenu')) {
			Xcore_AdminSideMenu::clearCache();
		}

		return true;
	}

	/**
	 * Delete a module from the database
	 *
	 * @param	object	&$module
	 * @return	bool
	 **/
	function delete(&$module)
	{
		if (strtolower(get_class($module)) != 'xoopsmodule') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE mid = %u", $this->db->prefix('modules'), $module->getVar('mid'));
		if ( !$result = $this->db->query($sql) ) {
			return false;
		}
		// delete admin permissions assigned for this module
		$sql = sprintf("DELETE FROM %s WHERE gperm_name = 'module_admin' AND gperm_itemid = %u", $this->db->prefix('group_permission'), $module->getVar('mid'));
		$this->db->query($sql);
		// delete read permissions assigned for this module
		$sql = sprintf("DELETE FROM %s WHERE gperm_name = 'module_read' AND gperm_itemid = %u", $this->db->prefix('group_permission'), $module->getVar('mid'));
		$this->db->query($sql);

		if ($module->getVar('mid')==1) {
			$sql = sprintf("DELETE FROM %s WHERE gperm_name = 'system_admin'", $this->db->prefix('group_permission'));
		} else {
			$sql = sprintf("DELETE FROM %s WHERE gperm_modid = %u", $this->db->prefix('group_permission'), $module->getVar('mid'));
		}
		$this->db->query($sql);

		$sql = sprintf("SELECT block_id FROM %s WHERE module_id = %u", $this->db->prefix('block_module_link'), $module->getVar('mid'));
		if ($result = $this->db->query($sql)) {
			$block_id_arr = array();
			while ($myrow = $this->db->fetchArray($result))
{
				array_push($block_id_arr, $myrow['block_id']);
			}
		}
		// loop through block_id_arr
		if (isset($block_id_arr)) {
			foreach ($block_id_arr as $i) {
				$sql = sprintf("SELECT block_id FROM %s WHERE module_id != %u AND block_id = %u", $this->db->prefix('block_module_link'), $module->getVar('mid'), $i);
				if ($result2 = $this->db->query($sql)) {
					if (0 < $this->db->getRowsNum($result2)) {
					// this block has other entries, so delete the entry for this module
						$sql = sprintf("DELETE FROM %s WHERE (module_id = %u) AND (block_id = %u)", $this->db->prefix('block_module_link'), $module->getVar('mid'), $i);
						$this->db->query($sql);
					} else {
					// this block doesnt have other entries, so disable the block and let it show on top page only. otherwise, this block will not display anymore on block admin page!
						$sql = sprintf("UPDATE %s SET visible = 0 WHERE bid = %u", $this->db->prefix('newblocks'), $i);
						$this->db->query($sql);
						$sql = sprintf("UPDATE %s SET module_id = -1 WHERE module_id = %u", $this->db->prefix('block_module_link'), $module->getVar('mid'));
						$this->db->query($sql);
					}
				}
			}
		}

		if (!empty($this->_cachedModule_dirname[$module->getVar('dirname')])) {
			unset ($this->_cachedModule_dirname[$module->getVar('dirname')]);
		}
		if (!empty($this->_cachedModule_mid[$module->getVar('mid')])) {
			unset ($this->_cachedModule_mid[$module->getVar('mid')]);
		}
		return true;
	}

	/**
	 * Load some modules
	 *
	 * @param	object	$criteria	{@link CriteriaElement}
	 * @param	boolean $id_as_key	Use the ID as key into the array
	 * @return	array
	 **/
	function &getObjects($criteria = null, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$db = &$this->db;
		$sql = 'SELECT * FROM '.$db->prefix('modules');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();

			if($criteria->getSort()!=null) {
				$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
			}
			else {
				$sql .= ' ORDER BY weight '.$criteria->getOrder().', mid ASC';
			}

			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}
		$result = $db->query($sql, $limit, $start);
		if (!$result) {
			return $ret;
		}
		while ($myrow = $db->fetchArray($result)) {
			$mid = $myrow['mid'];
			if (isset($this->_cachedModule_mid[$mid])) {
				$module = $this->_cachedModule_mid[$mid];
			} else {
				$module =new XoopsModule();
				$module->assignVars($myrow);
				$this->_cachedModule_mid[$mid] = $module;
				$this->_cachedModule_dirname[$myrow['dirname']] = $module;
			}
			if (!$id_as_key) {
				$ret[] =& $module;
			} else {
				$ret[$mid] =& $module;
			}
			unset($module);
		}
		return $ret;
	}

	/**
	 * Count some modules
	 *
	 * @param	object	$criteria	{@link CriteriaElement}
	 * @return	int
	 **/
	function getCount($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('modules');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result =& $this->db->query($sql)) {
			return 0;
		}
		list($count) = $this->db->fetchRow($result);
		return $count;
	}

	/**
	 * returns an array of module names
	 *
	 * @param	bool	$criteria
	 * @param	boolean $dirname_as_key
	 *		if true, array keys will be module directory names
	 *		if false, array keys will be module id
	 * @return	array
	 **/
	function &getList($criteria = null, $dirname_as_key = false)
	{
		$ret = array();
		$modules =& $this->getObjects($criteria, true);
		foreach ($modules as $i=>$module) {
			if (!$dirname_as_key) {
				$ret[$i] =& $module->getVar('name');
			} else {
				$ret[$module->getVar('dirname')] =& $module->getVar('name');
			}
		}
		return $ret;
	}
}
