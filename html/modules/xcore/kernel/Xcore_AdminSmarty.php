<?php

/**
 * @internal
 * @public
 * @brief The special extended smarty class for Xcore_AdminRenderSystem.
 * This class extends Smarty to mediate the collision compiled file name.
 */
use XCore\Kernel\Root;

class Xcore_AdminSmarty extends Smarty
{
	var $mModulePrefix = null;

	//
	// If you don't hope to override for theme, set false.
	//
	var $overrideMode = true;
	
	function __construct()
	{
		parent::__construct();

		$this->compile_id = XOOPS_URL;
		$this->_canUpdateFromFile = true;
		$this->compile_check = true;
		$this->compile_dir = XOOPS_COMPILE_PATH;
		$this->left_delimiter = '<{';
		$this->right_delimiter = '}>';
		$this->plugins_dir = array(SMARTY_DIR.'plugins', XOOPS_ROOT_PATH.'/modules/xcore/Helper');

		//
		// [TODO]
		//	If we don't set true to the following flag, a user can not recover
		// with deleting additional theme. But, a user should to select true or
		// false by site_custom.ini.php.
		//
		$this->force_compile = false;
	}
	
	function setModulePrefix($prefix)
	{
		$this->mModulePrefix = $prefix;
	}
	
	function _get_auto_filename($autoBase, $autoSource = null, $auotId = null)
	{
		$autoSource = $this->mModulePrefix . '_admin_' . $autoSource;
		return parent::_get_auto_filename($autoBase, $autoSource, $auotId);
	}

	function _fetch_resource_info(&$params)
	{
		$_return = false;

		$root = Root::getSingleton();
		$theme = $root->mSiteConfig['Xcore']['Theme'];
		$dirname = $this->mModulePrefix;
		
		if ($dirname != null) {
			$params['resource_base_path'] = XOOPS_THEME_PATH . '/' . $theme . '/modules/' . $dirname;
			$params['quiet'] = true;
			
			$_return = parent::_fetch_resource_info($params);
		}

		if (!$_return) {
			unset ($params['resource_base_path']);
			$params['quiet'] = false;
			
			$_return = parent::_fetch_resource_info($params);
		}
		
		return $_return;
	}
	
}
