<?php

/**
 * @brief The framework for the phased update.
 * 
 * @section Description
 * 
 * You can make your own custom-update-installer for your modules with the
 * sub-class of this class. It's easy to make by many utility functions. You
 * can write your sub-class as well as batch files.
 * 
 * On Legacy System module, upgrade is called when users try to update. So you
 * must implement your sub-class for also correct update. For example, the
 * custom-update-install have to update module templates & block templates,
 * because users expect that the module-update function does it.
 * 
 * For the custom-update-install, Xcore_ModuleInstallUtils is good for you.
 * Plus, this class has some usefull static methods for upgrade. Such functions
 * have notes as "The utility method for the custom-update-installer".
 * 
 * And, this class as the template-pattern has some methods you may override.
 * These methods have note as "You may do custom".
 * 
 * @section Convention
 * 
 * Module Update function build the current-$xoopsModule from DB, and then sets
 * it to this class through setCurrentModule(). Basically, you can access
 * it by $this->_mCurrentModule. And, that function build the
 * target-$xoopsModule from xoops_version, and then set it to this class through
 * setTargetModule(). Also you can access it by $this->_mTargetModule.
 * 
 * @see Xcore_ModuleInstallUtils
 */
use XCore\Kernel\Ref;
use XCore\Utils\Utils;
use XCore\Entity\Module;

class Xcore_ModulePhasedUpgrader
{
	/**
	 * This is an array of milestone version informations. Key is a version
	 * number. Value is a method name called by execute().
	 * 
	 * Format:
	 * {version} => {methodName}
	 * 
	 * Example:
	 * var $_mMilestone = array('020' => 'update020', '025' => 'update025');
	 * 
	 * @access protected
	 */
	var $_mMilestone = array();
	
	/**
	 * This instance is prepared automatically in the constructor.
	 * 
	 * @public
	 * @var Xcore_ModuleInstallLog
	 */
	var $mLog = null;
	
	/**
	 * @var Module
	 * @remark [Precondition] _mXoopsModule has to be an object.
	 */
	var $_mCurrentModule;
	
	/**
	 * @var int
	 */
	var $_mCurrentVersion;

	/**
	 * @var Module
	 * @remark [Precondition] _mXoopsModule has to be an object.
	 */
	var $_mTargetModule;
	
	/**
	 * @var int
	 */
	var $_mTargetVersion;
	
	/**
	 * @var bool
	 */
	var $_mForceMode = false;
	
	function Xcore_ModulePhasedUpgrader()
	{
		$this->mLog =new Xcore_ModuleInstallLog();
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
	 * Sets the current Module. This method creates the clone of this
	 * object to prevent cache of the module handler, and then keep it to the
	 * property. Plus, this method copies the version value of this object to
	 * the _mCurrentVersion as backup for the case where the value of this
	 * object is changed for updating.
	 * 
	 * @public
	 * @param Module $xoopsModule
	 */
	function setCurrentModule(&$xoopsModule)
	{
		$handler =& xoops_gethandler('module');
		$cloneModule =& $handler->create();
		
		$cloneModule->unsetNew();
		$cloneModule->set('mid', $xoopsModule->get('mid'));
		$cloneModule->set('name', $xoopsModule->get('name'));
		$cloneModule->set('version', $xoopsModule->get('version'));
		$cloneModule->set('last_update', $xoopsModule->get('last_update'));
		$cloneModule->set('weight', $xoopsModule->get('weight'));
		$cloneModule->set('isactive', $xoopsModule->get('isactive'));
		$cloneModule->set('dirname', $xoopsModule->get('dirname'));
		$cloneModule->set('hasmain', $xoopsModule->get('hasmain'));
		$cloneModule->set('hasadmin', $xoopsModule->get('hasadmin'));
		$cloneModule->set('hassearch', $xoopsModule->get('hassearch'));
		$cloneModule->set('hasconfig', $xoopsModule->get('hasconfig'));
		$cloneModule->set('hascomments', $xoopsModule->get('hascomments'));
		$cloneModule->set('hasnotification', $xoopsModule->get('hasnotification'));
		
		$this->_mCurrentModule =& $cloneModule;
		$this->_mCurrentVersion = $cloneModule->get('version');
	}
	
	/**
	 * Sets the target Module.
	 * 
	 * @access public
	 * @param Module $xoopsModule
	 */
	function setTargetModule(&$xoopsModule)
	{
		$this->_mTargetModule =& $xoopsModule;
		$this->_mTargetVersion = $this->getTargetPhase();
	}
	
	/**
	 * Execute upgrade. If the specific method for the milestone, this method
	 * calls the method. If such milestone doesn't exist, call the automatic
	 * upgrade method.
	 * 
	 * @access public
	 */
	function executeUpgrade()
	{
		if ($this->hasUpgradeMethod()) {
			return $this->_callUpgradeMethod();
		}
		else {
			return $this->executeAutomaticUpgrade();
		}
	}

	/**
	 * Gets the current version.
	 * 
	 * @return int
	 */
	function getCurrentVersion()
	{
		return $this->_mCurrentVersion;
	}
	
	/**
	 * Gets the target varsion number at this time. In the case where there are
	 * milestones, gets the nearest value from the current version.
	 * 
	 * Of course, this class is good to override by the sub-class.
	 */
	function getTargetPhase()
	{
		ksort($this->_mMilestone);
		
		foreach ($this->_mMilestone as $t_version => $t_value) {
			if ($t_version > $this->getCurrentVersion()) {
				return $t_version;
			}
		}
		
		return $this->_mTargetModule->get('version');
	}
	
	/**
	 * Gets the valude indicating whether this class 
	 */
	function hasUpgradeMethod()
	{
		ksort($this->_mMilestone);
		
		foreach ($this->_mMilestone as $t_version => $t_value) {
			if ($t_version > $this->getCurrentVersion()) {
				if (is_callable(array($this, $t_value))) {
					return true;
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Dispatches the callback upgrade program.
	 * 
	 * @access protected
	 * @return bool The value indicating whether this method can call the
	 *              upgrade-method.
	 */
	function _callUpgradeMethod()
	{
		ksort($this->_mMilestone);
		
		foreach ($this->_mMilestone as $t_version => $t_value) {
			if ($t_version > $this->getCurrentVersion()) {
				if (is_callable(array($this, $t_value))) {
					return $this->$t_value();
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Gets a valude indicating whether this process is upgrade for the latest
	 * version.
	 * 
	 * @return bool
	 */
	function isLatestUpgrade()
	{
		return ($this->_mTargetModule->get('version') == $this->getTargetPhase());
	}
	
	/**
	 * Saves Module object to DB.
	 * 
	 * @access protected
	 */	
	function saveModule(&$module)
	{
		$handler =& xoops_gethandler('module');
		if ($handler->insert($module)) {
			$this->mLog->addReport("Module is updated.");
		}
		else {
			$this->mLog->addError("Could not update module information.");
		}
	}
	
	function _processScript()
	{
		$installScript = trim($this->_mTargetModule->getInfo('onUpdate'));
		if ($installScript != false) {
			require_once XOOPS_MODULE_PATH . "/" . $this->_mTargetModule->get('dirname') . "/" . $installScript;
			$funcName = 'xoops_module_update_' . $this->_mTargetModule->get('dirname');
			if (function_exists($funcName)) {
				if (!call_user_func($funcName, $this->_mTargetModule, $this->getCurrentVersion(), new Ref($this->mLog))) {
					$this->mLog->addError("Failed to execute " . $funcName);
				}
			}
		}
	}
	
	function _processReport()
	{
		if (!$this->mLog->hasError()) {
			$this->mLog->add(Utils::formatMessage(_AD_XCORE_MESSAGE_UPDATING_MODULE_SUCCESSFUL, $this->_mCurrentModule->get('name')));
		}
		else {
			$this->mLog->addError(Utils::formatMessage(_AD_XCORE_ERROR_UPDATING_MODULE_FAILURE, $this->_mCurrentModule->get('name')));
		}
	}
	
	/**
	 * Updates all of module templates.
	 * 
	 * @access protected
	 * @note You may do custom
	 */
	function _updateModuleTemplates()
	{
		Xcore_ModuleInstallUtils::clearAllOfModuleTemplatesForUpdate($this->_mTargetModule, $this->mLog);
		Xcore_ModuleInstallUtils::installAllOfModuleTemplates($this->_mTargetModule, $this->mLog);
	}
	
	/**
	 * Updates all of blocks.
	 * 
	 * @access protected
	 * @note You may do custom
	 */
	function _updateBlocks()
	{
		Xcore_ModuleInstallUtils::smartUpdateAllOfBlocks($this->_mTargetModule, $this->mLog);
	}
	
	/**
	 * Updates all of preferences & notifications.
	 * 
	 * @access protected
	 * @note You may do custom
	 */
	function _updatePreferences()
	{
		Xcore_ModuleInstallUtils::smartUpdateAllOfPreferences($this->_mTargetModule, $this->mLog);
	}
	
	/**
	 * This method executes upgrading automatically by the diff of
	 * xoops_version.
	 * 
	 * 1) Uninstall all of module templates
	 * 2) Install all of module templates
	 * 
	 * @return bool
	 */
	function executeAutomaticUpgrade()
	{
		$this->mLog->addReport(_AD_XCORE_MESSAGE_UPDATE_STARTED);
		
		//
		// Updates all of module templates
		//
		$this->_updateModuleTemplates();
		if (!$this->_mForceMode && $this->mLog->hasError()) {
			$this->_processReport();
			return false;
		}
		
		//
		// Update blocks.
		//
		$this->_updateBlocks();
		if (!$this->_mForceMode && $this->mLog->hasError()) {
			$this->_processReport();
			return false;
		}
		
		//
		// Update preferences & notifications.
		//
		$this->_updatePreferences();
		if (!$this->_mForceMode && $this->mLog->hasError()) {
			$this->_processReport();
			return false;
		}
		
		//
		// Update module object.
		//
		$this->saveModule($this->_mTargetModule);
		if (!$this->_mForceMode && $this->mLog->hasError()) {
			$this->_processReport();
			return false;
		}

		//
		// call back 'onUpdate'
		//
		$this->_processScript();
		if (!$this->_mForceMode && $this->mLog->hasError()) {
			$this->_processReport();
			return false;
		}
		
		$this->_processReport();
		
		return true;
	}
}

