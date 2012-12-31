<?php

use XCore\Kernel\Root;
use XCore\Utils\Utils;
use XCore\Entity\GroupPerm;
use XCore\Entity\Module;

class Xcore_ModuleUpdater extends Xcore_ModulePhasedUpgrader
{
	var $_mMilestone = array(
		'106' => 'update106',
		'200' => 'update200'
	);
	
	function update200()
	{
		$this->mLog->addReport(_AD_XCORE_MESSAGE_UPDATE_STARTED);
	
		// Update database table index.
		$this->_extendConfigTitleSize();
		if (!$this->_mForceMode && $this->mLog->hasError())
		{
			$this->_processReport();
			return false;
		}
	
		// Normal update process.
		$this->_updateModuleTemplates();
		if (!$this->_mForceMode && $this->mLog->hasError())
		{
			$this->_processReport();
			return false;
		}
		
		$this->_updateBlocks();
		if (!$this->_mForceMode && $this->mLog->hasError())
		{
			$this->_processReport();
			return false;
		}
		
		$this->_updatePreferences();
		if (!$this->_mForceMode && $this->mLog->hasError())
		{
			$this->_processReport();
			return false;
		}
		
		$this->saveModule($this->_mTargetModule);
		if (!$this->_mForceMode && $this->mLog->hasError())
		{
			$this->_processReport();
			return false;
		}
		
		$this->_processScript();
		if (!$this->_mForceMode && $this->mLog->hasError())
		{
			$this->_processReport();
			return false;
		}
		
		$this->_processReport();
		
		return true;
	}
	
	function update106()
	{
		$this->mLog->addReport(_AD_XCORE_MESSAGE_UPDATE_STARTED);
		
		// Update database table index.
		$this->_setUniqueToGroupUserLink();
		$this->_recoverGroupPermission();
		if (!$this->_mForceMode && $this->mLog->hasError())
		{
			$this->_processReport();
			return false;
		}
		
		// Normal update process.
		$this->_updateModuleTemplates();
		if (!$this->_mForceMode && $this->mLog->hasError())
		{
			$this->_processReport();
			return false;
		}
		
		$this->_updateBlocks();
		if (!$this->_mForceMode && $this->mLog->hasError())
		{
			$this->_processReport();
			return false;
		}
		
		$this->_updatePreferences();
		if (!$this->_mForceMode && $this->mLog->hasError())
		{
			$this->_processReport();
			return false;
		}
		
		$this->saveModule($this->_mTargetModule);
		if (!$this->_mForceMode && $this->mLog->hasError())
		{
			$this->_processReport();
			return false;
		}
		
		$this->_processScript();
		if (!$this->_mForceMode && $this->mLog->hasError())
		{
			$this->_processReport();
			return false;
		}
		
		$this->_processReport();
		
		return true;
	}
	
	/**
	 * @brief extend config_title and config_desc size in config table.
	 * @author kilica
	 */
	function _extendConfigTitleSize()
	{
		$root = Root::getSingleton();
		$db =& $root->mController->getDB();
		$table = $db->prefix('config');
	
		$sql = 'ALTER TABLE `'. $table .'` MODIFY `conf_title` varchar(255) NOT NULL default "", MODIFY `conf_desc` varchar(255) NOT NULL default ""';

		if ($db->query($sql))
		{
			$this->mLog->addReport(Utils::formatString(_AD_XCORE_MESSAGE_EXTEND_CONFIG_TITLE_SIZE_SUCCESSFUL, $table));
		}
		else
		{
			$this->mLog->addError(Utils::formatString(_AD_XCORE_ERROR_COULD_NOT_EXTEND_CONFIG_TITLE_SIZE, $table));
		}
	}

	function _setUniqueToGroupUserLink()
	{
		$root = Root::getSingleton();
		$db =& $root->mController->getDB();
		$table = $db->prefix('groups_users_link');
		
		// Delete duplicate data.
		$sql = 'SELECT `uid`,`groupid`,COUNT(*) AS c FROM `' . $table . '` GROUP BY `uid`,`groupid` HAVING `c` > 1';
		if ($res = $db->query($sql))
		{
			while ($row = $db->fetchArray($res))
			{
				$sql = sprintf('DELETE FROM `%s` WHERE `uid` = %d AND `groupid` = %d ORDER BY `linkid` DESC', $table, $row['uid'], $row['groupid']);
				if (!$db->query($sql, $row['c'] - 1))
				{
					$this->mLog->addError(Utils::formatString(_AD_XCORE_ERROR_COULD_NOT_DELETE_DUPLICATE_DATA, $table));
					return;
				}
			}
		}
		
		// Set unique key.
		$sql = 'ALTER TABLE `' . $table . '` DROP INDEX `groupid_uid`';
		$db->query($sql); // ignore sql errors
		$sql = 'ALTER TABLE `' . $table . '` ADD UNIQUE `uid_groupid` (`uid`,`groupid`)';
		if ($db->query($sql))
		{
			$this->mLog->addReport(Utils::formatString(_AD_XCORE_MESSAGE_SET_UNIQUE_KEY_SUCCESSFUL, $table));
		}
		else
		{
			$this->mLog->addError(Utils::formatString(_AD_XCORE_ERROR_COULD_NOT_SET_UNIQUE_KEY, $table));
		}
	}

	/**
	 * @brief Removes invalid permission instances from DB.
	 * @author orrisroot
	 */
	function _recoverGroupPermission()
	{
		$root = Root::getSingleton();
		$db =& $root->mController->getDB();
		
		$permTable = $db->prefix('group_permission');
		$groupTable = $db->prefix('groups');
		$sql = sprintf("SELECT DISTINCT `gperm_groupid` FROM `%s` LEFT JOIN `%s` ON `%s`.`gperm_groupid`=`%s`.`groupid`" .
					   " WHERE `gperm_modid`=1 AND `groupid` IS NULL",
					   $permTable, $groupTable, $permTable, $groupTable);
		$result = $db->query($sql);
		if (!$result) {
			return false;
		}
		
		$gids = array();
		while ($myrow = $db->fetchArray($result)) {
			$gids[] = $myrow['gperm_groupid'];
		}
		
		$db->freeRecordSet( $result );
		
		// remove all invalid group id entries
		if (count( $gids ) != 0) {
			$sql = sprintf('DELETE FROM `%s` WHERE `gperm_groupid` IN (%s) AND `gperm_modid`=1',
						   $permTable, implode(',', $gids));
			$result = $xoopsDB->query($sql);
			if (!$result) {
				return false;
			}
		}
		
		return true;
	}
}

