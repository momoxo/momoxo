<?php

use XCore\Repository\ObjectGenericRepository;

class XcoreGroup_permissionHandler extends ObjectGenericRepository
{
	var $mTable = "group_permission";
	var $mPrimary = "gperm_id";
	var $mClass = "XcoreGroup_permissionObject";
	
	/**
	 * Gets array of roles by array of group ID.
	 * @param int $mid
	 * @param array $groups
	 * @return array
	 */
	function getRolesByModule($mid, $groups)
	{
		$retRoles = array();
		
		$sql = "SELECT gperm_name FROM " . $this->mTable . " WHERE gperm_modid=" . intval($mid) . " AND gperm_itemid=0 AND ";
		$groupSql = array();
		
		foreach ($groups as $gid) {
			$groupSql[] = "gperm_groupid=" . intval($gid);
		}
		
		$sql .= "(" . implode(' OR ', $groupSql) . ")";
		
		$result = $this->db->query($sql);
		
		if (!$result) {
			return $retRoles;
		}
		
		while ($row = $this->db->fetchArray($result)) {
			$retRoles[] = $row['gperm_name'];
		}
		
		return $retRoles;
	}
}
