<?php

use XCore\Kernel\Root;
use XCore\Kernel\Ref;
use XCore\Kernel\Delegate;
use XCore\Utils\Utils;
use XCore\Database\Criteria;
use XCore\Entity\Module;

class Xcore_ModuleUninstaller
{
	/**
	 * This instance is prepared automatically in the constructor.
	 * 
	 * @public
	 * @var Xcore_ModuleInstallLog
	 */
	var $mLog = null;
	
	var $_mForceMode = false;
	
	/**
	 * @protected
	 * @var Module
	 * @remark [Precondition] _mXoopsModule has to be an object.
	 */
	var $_mXoopsModule = null;
	
	/**
	 * @var Delegate
	 * @attention
	 *     This may be changed in the future.
	 * @todo
	 *     We may have to move this delegate to another class. Or, we may
	 *     have to add the same delegates to other installer classes.
	 */
	var $m_fireNotifyUninstallTemplateBegun;
	
	function Xcore_ModuleUninstaller()
	{
		$this->mLog =new Xcore_ModuleInstallLog();
		$this->m_fireNotifyUninstallTemplateBegun =new Delegate();
		$this->m_fireNotifyUninstallTemplateBegun->register("Xcore_ModuleUninstaller._fireNotifyUninstallTemplateBegun");
	}
	
	/**
	 * Sets the current Module.
	 * 
	 * @public
	 * @param Module $xoopsModule
	 */
	function setCurrentModule(&$xoopsModule)
	{
		$this->_mXoopsModule =& $xoopsModule;
	}
	
	/**
	 * Sets a value indicating whether the force mode is on.
	 * @param bool $isForceMode
	 */
	function setForceMode($isForceMode)
	{
		$this->_mForceMode = $isForceMode;
	}
	
	/**
	 * Deletes module information from XOOPS database because this class is
	 * uninstaller.
	 * 
	 * @protected
	 */
	function _uninstallModule()
	{
		$moduleHandler =& xoops_gethandler('module');
		if (!$moduleHandler->delete($this->_mXoopsModule)) {
			$this->mLog->addError(_AD_XCORE_ERROR_DELETE_MODULEINFO_FROM_DB);
		}
		else {
			$this->mLog->addReport(_AD_XCORE_MESSAGE_DELETE_MODULEINFO_FROM_DB);
		}
	}

	/**
	 * Drop table because this class is uninstaller.
	 * 
	 * @protected
	 */
	function _uninstallTables()
	{
		$root = Root::getSingleton();
		$db = $root->mController->getDB();

		$dirname = $this->_mXoopsModule->get('dirname');
		$t_search = array('{prefix}', '{dirname}', '{Dirname}', '{_dirname_}');
		$t_replace = array(XOOPS_DB_PREFIX, strtolower($dirname), ucfirst(strtolower($dirname)), $dirname);
		
		$tables = $this->_mXoopsModule->getInfo('tables');
		if ($tables != false && is_array($tables)) {
			foreach($tables as $table) {
				//
				// TODO Do we need to check reserved core tables?
				//
				$t_tableName = $table;
				if (isset($this->_mXoopsModule->modinfo['cube_style']) && $this->_mXoopsModule->modinfo['cube_style'] == true) {
					$t_tableName = str_replace($t_search, $t_replace, $table);
				}
				else {
					$t_tableName = $db->prefix($table);
				}
				
				$sql = "DROP TABLE " . $t_tableName;
				
				if ($db->query($sql)) {
					$this->mLog->addReport(Utils::formatMessage(_AD_XCORE_MESSAGE_DROP_TABLE, $t_tableName));
				}
				else {
					$this->mLog->addError(Utils::formatMessage(_AD_XCORE_ERROR_DROP_TABLE, $t_tableName));
				}
			}
		}
	}

	/**
	 * Delete template because this class is uninstaller.
	 * @protected
	 */
	function _uninstallTemplates()
	{
		$this->m_fireNotifyUninstallTemplateBegun->call(new Ref($this->_mXoopsModule));
		Xcore_ModuleInstallUtils::uninstallAllOfModuleTemplates($this->_mXoopsModule, $this->mLog);
	}

	/**
	 * Delete all of module's blocks.
	 * 
	 * @note Templates Delete is move into Xcore_ModuleInstallUtils.
	 */
	function _uninstallBlocks()
	{
		Xcore_ModuleInstallUtils::uninstallAllOfBlocks($this->_mXoopsModule, $this->mLog);

		//
		// Additional
		//
		$tplHandler =& xoops_gethandler('tplfile');
		$criteria =new Criteria('tpl_module', $this->_mXoopsModule->get('dirname'));
		if(!$tplHandler->deleteAll($criteria)) {
			$this->mLog->addError(Utils::formatMessage(_AD_XCORE_ERROR_COULD_NOT_DELETE_BLOCK_TEMPLATES, $tplHandler->db->error()));
		}
	}

	function _uninstallPreferences()
	{
		Xcore_ModuleInstallUtils::uninstallAllOfConfigs($this->_mXoopsModule, $this->mLog);
		Xcore_ModuleInstallUtils::deleteAllOfNotifications($this->_mXoopsModule, $this->mLog);
		Xcore_ModuleInstallUtils::deleteAllOfComments($this->_mXoopsModule, $this->mLog);
	}

	function _processScript()
	{
		$installScript = trim($this->_mXoopsModule->getInfo('onUninstall'));
		if ($installScript != false) {
			require_once XOOPS_MODULE_PATH . "/" . $this->_mXoopsModule->get('dirname') . "/" . $installScript;
			$funcName = 'xoops_module_uninstall_' . $this->_mXoopsModule->get('dirname');
			
			if (!preg_match("/^[a-zA-Z_][a-zA-Z0-9_]*$/", $funcName)) {
				$this->mLog->addError(XCUbe_Utils::formatMessage(_AD_XCORE_ERROR_FAILED_TO_EXECUTE_CALLBACK, $funcName));
				return;
			}
			
			if (function_exists($funcName)) {
				if (!call_user_func($funcName, $this->_mXoopsModule, new Ref($this->mLog))) {
					$this->mLog->addError(Utils::formatMessage(_AD_XCORE_ERROR_FAILED_TO_EXECUTE_CALLBACK, $funcName));
				}
			}
		}
	}
	
	function _processReport()
	{
		if (!$this->mLog->hasError()) {
			$this->mLog->add(Utils::formatMessage(_AD_XCORE_MESSAGE_UNINSTALLATION_MODULE_SUCCESSFUL, $this->_mXoopsModule->get('name')));
		}
		else {
			$this->mLog->addError(Utils::formatMessage(_AD_XCORE_ERROR_UNINSTALLATION_MODULE_FAILURE, $this->_mXoopsModule->get('name')));
		}
	}

	/**
	 * @todo Check whether $this->_mXoopsObject is ready.
	 */
	function executeUninstall()
	{
		$this->_uninstallTables();
		if (!$this->_mForceMode && $this->mLog->hasError()) {
			$this->_processReport();
			return false;
		}
		if ($this->_mXoopsModule->get('mid') != null) {
			$this->_uninstallModule();
			if (!$this->_mForceMode && $this->mLog->hasError()) {
				$this->_processReport();
				return false;
			}

			$this->_uninstallTemplates();
			if (!$this->_mForceMode && $this->mLog->hasError()) {
				$this->_processReport();
				return false;
			}

			$this->_uninstallBlocks();
			if (!$this->_mForceMode && $this->mLog->hasError()) {
				$this->_processReport();
				return false;
			}
			
			$this->_uninstallPreferences();
			if (!$this->_mForceMode && $this->mLog->hasError()) {
				$this->_processReport();
				return false;
			}
			
			$this->_processScript();
			if (!$this->_mForceMode && $this->mLog->hasError()) {
				$this->_processReport();
				return false;
			}
		}
		$this->_processReport();
		
		return true;
	}
}

