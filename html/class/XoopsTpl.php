<?php

/**
 * Template engine
 *
 * @package		kernel
 * @subpackage	core
 *
 * @author		Kazumi Ono 	<onokazu@xoops.org>
 * @copyright	(c) 2000-2003 The Xoops Project - www.xoops.org
 */
use XCore\Kernel\Ref;
use XCore\Kernel\DelegateUtils;

class XoopsTpl extends Smarty
{

	/**
	 * Allow update of template files from the themes/ directory?
     * This should be set to false on an active site to increase performance
	 */
	var $_canUpdateFromFile = false;

	/**
	 * Constructor
	 **/
	function XoopsTpl()
	{
		global $xoopsConfig;
		$this->Smarty();
		$this->compile_id = XOOPS_URL;
		if ($xoopsConfig['theme_fromfile'] == 1) {
			$this->_canUpdateFromFile = true;
			$this->compile_check = true;
		} else {
			$this->_canUpdateFromFile = false;
			$this->compile_check = false;
		}
		$this->left_delimiter =  '<{';
		$this->right_delimiter =  '}>';
		$this->template_dir = XOOPS_THEME_PATH;
		$this->cache_dir = XOOPS_CACHE_PATH;
		$this->compile_dir = XOOPS_COMPILE_PATH;
		//loading under root_path for compatibility with XCL2.1
		$this->plugins_dir = array(SMARTY_DIR.'plugins', XOOPS_ROOT_PATH.'/modules/xcore/Helper');
//		$this->default_template_handler_func = 'xoops_template_create';
		$this->use_sub_dirs = false;

		$this->assign(array('xoops_url' => XOOPS_URL,
							'xoops_rootpath' => XOOPS_ROOT_PATH,
							'xoops_langcode' => _LANGCODE,
							'xoops_charset' => _CHARSET,
							'xoops_version' => XOOPS_VERSION,
							'xoops_upload_url' => XOOPS_UPLOAD_URL
							));

	    if(empty($this->debug_tpl)) {
	        // set path to debug template from SMARTY_DIR
	        $this->debug_tpl = XOOPS_ROOT_PATH.'/modules/xcore/templates/xoops_debug.tpl';
	        if($this->security && is_file($this->debug_tpl)) {
	            $this->secure_dir[] = realpath($this->debug_tpl);
	        }
	        $this->debug_tpl = 'file:' . XOOPS_ROOT_PATH.'/modules/xcore/templates/xoops_debug.tpl';
	    }

        // Delegate 'XoopsTpl.New'
        //  Delegate may define additional initialization code for XoopTpl Instance;
        //  varArgs : 
        //      'xoopsTpl'     [I/O] : $this
        //
		DelegateUtils::call('XoopsTpl.New',  new Ref($this));
	}

	/**
	 * Set the directory for templates
     * 
     * @param   string  $dirname    Directory path without a trailing slash
	 **/
	function xoops_setTemplateDir($dirname)
	{
		$this->template_dir = $dirname;
	}

	/**
	 * Get the active template directory
	 * 
	 * @return  string
	 **/
	function xoops_getTemplateDir()
	{
		return $this->template_dir;
	}

	/**
	 * Set debugging mode
	 * 
	 * @param   boolean     $flag
	 **/
	function xoops_setDebugging($flag=false)
	{
		$this->debugging = is_bool($flag) ? $flag : false;
	}

	/**
	 * Set caching
	 * 
	 * @param   integer     $num
	 **/
	function xoops_setCaching($num=0)
	{
		$this->caching = (int)$num;
	}

	/**
	 * Set cache lifetime
	 * 
	 * @param   integer     $num    Cache lifetime
	 **/
	function xoops_setCacheTime($num=0)
	{
		$num = (int)$num;
		if ($num <= 0) {
			$this->caching = 0;
		} else {
			$this->cache_lifetime = $num;
		}
	}

	/**
	 * Set directory for compiled template files
	 * 
	 * @param   string  $dirname    Full directory path without a trailing slash
	 **/
	function xoops_setCompileDir($dirname)
	{
		$this->compile_dir = $dirname;
	}

	/**
	 * Set the directory for cached template files
	 * 
	 * @param   string  $dirname    Full directory path without a trailing slash
	 **/
	function xoops_setCacheDir($dirname)
	{
		$this->cache_dir = $dirname;
	}

	/**
	 * Render output from template data
	 * 
	 * @deprecated
	 *
	 * @param   string  $data
	 * @return  string  Rendered output  
	 **/
	function xoops_fetchFromData(&$data)
	{
		$dummyfile = XOOPS_CACHE_PATH.'/dummy_'.time();
		$fp = fopen($dummyfile, 'w');
		fwrite($fp, $data);
		fclose($fp);
		$fetched = $this->fetch('file:'.$dummyfile);
		unlink($dummyfile);
		$this->clear_compiled_tpl('file:'.$dummyfile);
		return $fetched;
	}

	/**
	 * 
	 **/
	function xoops_canUpdateFromFile()
	{
		return $this->_canUpdateFromFile;
	}
	
	function &fetchBlock($template,$bid)
	{
		$ret = $this->fetch('db:'.$template,$bid);
        return $ret;
	}
	
	function isBlockCached($template,$bid)
	{
		return $this->is_cached('db:'.$template, 'blk_'.$bid);
	}
	
	function isModuleCached($templateName,$dirname)
	{
		if(!$templateName)
			$templateName='system_dummy.html';

        return $this->is_cached('db:'.$templateName, $this->getModuleCachedTemplateId($dirname));
	}

	function fetchModule($templateName,$dirname)
	{
		if(!$templateName)
			$templateName='system_dummy.html';

        return $this->fetch('db:'.$templateName, $this->getModuleCachedTemplateId($dirname));
	}
	
	function getModuleCachedTemplateId($dirname)
	{
		return 'mod_'.$dirname.'|'.md5(str_replace(XOOPS_URL, '', $GLOBALS['xoopsRequestUri']));
	}

	/**
	 * Return smarty's debug console if debug mode is active.
	 *
	 * @return string
	 */	
	function fetchDebugConsole()
	{
		if ($this->debugging) {
			// capture time for debugging info
			$_params = array();
			require_once(SMARTY_CORE_DIR . 'core.get_microtime.php');
			$this->_smarty_debug_info[$_included_tpls_idx]['exec_time'] = (smarty_core_get_microtime($_params, $this) - $_debug_start_time);
			require_once(SMARTY_CORE_DIR . 'core.display_debug_console.php');
			return smarty_core_display_debug_console($_params, $this);
		}
	}
}
