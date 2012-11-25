<?php

class XcoreThemeHandler extends XoopsObjectHandler
{
	var $_mResults = array();
	
	/**
	 * @var XCube_Delegate
	 */
	var $mGetInstalledThemes = null;
	
	function XcoreThemeHandler(&$db)
	{
		$this->mGetInstalledThemes =new XCube_Delegate();
		$this->mGetInstalledThemes->register('XcoreThemeHandler.GetInstalledThemes');
	}
	
	function &create()
	{
		$ret =new XcoreThemeObject();
		return $ret;
	}
	
	function &get($name)
	{
		$ret = null;
		$this->_makeCache();
		
		foreach (array_keys($this->_mResults) as $key) {
			if ($this->_mResults[$key]->get('dirname') == $name) {
				return $this->_mResults[$key];
			}
		}
		
		return $ret;
	}
	
	function &getObjects($criteria = null, $id_as_key = false)
	{
		$this->_makeCache();
		return $this->_mResults;
	}
	
	/**
	 * Create cache at $this->mResult by Delegate, if cache is empty.
	 */
	function _makeCache()
	{
		if (count($this->_mResults) == 0) {
			$t_themeArr = array();
			$this->mGetInstalledThemes->call(new XCube_Ref($t_themeArr));
			
			foreach ($t_themeArr as $theme) {
				$obj =& $this->create();
				$obj->assignVars(array('name'			=> $theme->mName,
									   'dirname'		=> $theme->mDirname,
									   'screenshot'		=> $theme->mScreenShot,
									   'description'	=> $theme->mDescription,
									   'format'			=> $theme->mFormat,
									   'render_system'	=> $theme->mRenderSystemName,
									   'version'		=> $theme->mVersion,
									   'author'			=> $theme->mAuthor,
									   'url'			=> $theme->mUrl,
									   'license'		=> $theme->mLicence));
				$this->_mResults[] =& $obj;
				unset($obj);
			}
		}
	}
	
	function insert(&$obj, $force = false)
	{
		return false;
	}

	function delete(&$obj, $force = false)
	{
		return false;
	}
}
