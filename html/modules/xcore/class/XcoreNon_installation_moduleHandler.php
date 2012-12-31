<?php

class XcoreNon_installation_moduleHandler extends XoopsObjectHandler
{
	/***
	 * object cache.
	 * @var Array
	 */
	var $_mKarimojiModules = array();

	/***
	 * readonly property
	 */
	var $_mExclusions = array(".", "..", "CVS");
	
	function XcoreNon_installation_moduleHandler(&$db)
	{
		parent::XoopsObjectHandler($db);
		$this->_setupObjects();
	}

	/***
	 * Once, load module objects to a member property from XOOPS_MODULE_PATH.
	 */
	function _setupObjects()
	{
		if (count($this->_mKarimojiModules) == 0) {
			if ($handler = opendir(XOOPS_MODULE_PATH))	{
				while (($dir = readdir($handler)) !== false) {
					if (!in_array($dir, $this->_mExclusions) && is_dir(XOOPS_MODULE_PATH . "/" . $dir)) {
						$module =& $this->get($dir);
						if ($module !== false ) {
							$this->_mKarimojiModules[] =& $module;
						}
						unset($module);
					}
				}
			}
		}
	}
	
	/***
	 * Return module object by $dirname that is specified module directory.
	 * If specified module has been installed or doesn't keep xoops_version, not return it.
	 * @param $dirname string
	 * @param XoopsModule or false
	 */
	function &get($dirname)
	{
		$ret = false;
		
		if (!file_exists(XOOPS_MODULE_PATH . "/" . $dirname . "/xoops_version.php")) {
			return $ret;
		}

		$moduleHandler =& xoops_gethandler('module');

		$check =& $moduleHandler->getByDirname($dirname);
		if (is_object($check)) {
			return $ret;
		}

		$module =& $moduleHandler->create();
		$module->loadInfoAsVar($dirname);
		
		return $module;
	}

	function &getObjects($criteria=null)
	{
		return $this->_mKarimojiModules;
	}
	
	function &getObjectsFor2ndInstaller()
	{
		$ret = array();
		
		foreach (array_keys($this->_mKarimojiModules) as $key) {
			if (empty($this->_mKarimojiModules[$key]->modinfo['disable_xcore_2nd_installer'])) {
				$ret[] =& $this->_mKarimojiModules[$key];
			}
		}
		
		return $ret;
	}
}
