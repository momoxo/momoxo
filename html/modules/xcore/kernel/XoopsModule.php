<?php

/**
 * A Module
 *
 * @package 	kernel
 *
 * @author		Kazumi Ono	<onokazu@xoops.org>
 * @copyright	(c) 2000-2003 The Xoops Project - www.xoops.org
 */
use XCore\Kernel\Root;

class XoopsModule extends XoopsObject
{
	/**
	 * @var string
	 */
	var $modinfo;
	/**
	 * @var string
	 */
	var $adminmenu;

	/**
	 * Constructor
	 */
	function XoopsModule()
	{
		$this->XoopsObject();
		static $initVars;
		if (isset($initVars)) {
			$this->vars = $initVars;
			return;
		}
		$this->initVar('mid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 150);
		$this->initVar('version', XOBJ_DTYPE_INT, 100, false);
		$this->initVar('last_update', XOBJ_DTYPE_INT, null, false);
		$this->initVar('weight', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('isactive', XOBJ_DTYPE_INT, 1, false);
		$this->initVar('issystem', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('dirname', XOBJ_DTYPE_OTHER, null, true);
		$this->initVar('trust_dirname', XOBJ_DTYPE_OTHER, null, true);
		$this->initVar('role', XOBJ_DTYPE_OTHER, null, false);
		$this->initVar('hasmain', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('hasadmin', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('hassearch', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('hasconfig', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('hascomments', XOBJ_DTYPE_INT, 0, false);
		// RMV-NOTIFY
		$this->initVar('hasnotification', XOBJ_DTYPE_INT, 0, false);
		$initVars = $this->vars;
	}

	/**
	 * Load module info
	 *
	 * @param	string	$dirname	Directory Name
	 * @param	boolean $verbose
	 **/
	function loadInfoAsVar($dirname, $verbose = true)
	{
		if ( !isset($this->modinfo) ) {
			$this->loadInfo($dirname, $verbose);
		}
		$this->setVar('name', $this->modinfo['name'], true);
		$this->setVar('version', Xcore_Utils::convertVersionFromModinfoToInt($this->modinfo['version']));
		$this->setVar('dirname', $this->modinfo['dirname'], true);
		$trustDirname = isset($this->modinfo['trust_dirname']) ? $this->modinfo['trust_dirname'] : null;
		$this->setVar('trust_dirname', $trustDirname , true);
		$role = isset($this->modinfo['role']) ? $this->modinfo['role'] : null;
		$this->setVar('role', $role , true);
		$issystem = (isset($this->modinfo['issystem']) && $this->modinfo['issystem'] == 1) ? 1 : 0;
		$hasmain = (isset($this->modinfo['hasMain']) && $this->modinfo['hasMain'] == 1) ? 1 : 0;
		$hasadmin = (isset($this->modinfo['hasAdmin']) && $this->modinfo['hasAdmin'] == 1) ? 1 : 0;
		$hassearch = (isset($this->modinfo['hasSearch']) && $this->modinfo['hasSearch'] == 1) ? 1 : 0;
		$hasconfig = ((isset($this->modinfo['config']) && is_array($this->modinfo['config'])) || !empty($this->modinfo['hasComments'])) ? 1 : 0;
		$hascomments = (isset($this->modinfo['hasComments']) && $this->modinfo['hasComments'] == 1) ? 1 : 0;
		// RMV-NOTIFY
		$hasnotification = (isset($this->modinfo['hasNotification']) && $this->modinfo['hasNotification'] == 1) ? 1 : 0;
		$this->setVar('issystem', $issystem);
		$this->setVar('hasmain', $hasmain);
		$this->setVar('hasadmin', $hasadmin);
		$this->setVar('hassearch', $hassearch);
		$this->setVar('hasconfig', $hasconfig);
		$this->setVar('hascomments', $hascomments);
		// RMV-NOTIFY
		$this->setVar('hasnotification', $hasnotification);
	}

    // momoxo
    function &getVar($key, $format = 's')
    {
        $ret = parent::getVar($key, $format);
        if($key == 'weight'){
            if(parent::getVar('issystem') == 0){
                $ret = $ret - 10000;
            }
        }
        return $ret;
    }

	function setVar($key, $value, $not_gpc = false)
	{
		// TODO 複数カラムでのソートが上手く動かない為システムモジュール以外は優先度下げることで対応
		if ($key === 'weight' && $this->getVar('issystem') == 0) {
			$value = $value + 10000;
		}

		parent::setVar($key, $value, $not_gpc);
	}



    /**
	 * Get module info
	 *
	 * @param	string	$name
	 * @return	array|string	Array of module information.
	 *			If {@link $name} is set, returns a singel module information item as string.
	 **/
	function &getInfo($name=null)
	{
		if ( !isset($this->modinfo) ) {
			$this->loadInfo($this->getVar('dirname'));
		}
		if ( isset($name) ) {
			if ( isset($this->modinfo[$name]) ) {
				return $this->modinfo[$name];
			}
			$ret = false;
			return $ret;
		}
		return $this->modinfo;
	}

	/**
	 * Get a link to the modules main page
	 *
	 * @return	string	FALSE on fail
	 */
	function mainLink()
	{
		if ( $this->getVar('hasmain') == 1 ) {
			$ret = '<a href="'.XOOPS_URL.'/modules/'.$this->getVar('dirname').'/">'.$this->getVar('name').'</a>';
			return $ret;
		}
		return false;
	}

	/**
	 * Get links to the subpages
	 *
	 * @return	string
	 */
	function &subLink()
	{
		$ret = array();
		if ( $this->getInfo('sub') && is_array($this->getInfo('sub')) ) {
			foreach ( $this->getInfo('sub') as $submenu ) {
				$ret[] = array('name' => $submenu['name'], 'url' => $submenu['url']);
			}
		}
		return $ret;
	}

	/**
	 * Load the admin menu for the module
	 */
	function loadAdminMenu()
	{
		$menu = $this->getInfo('adminmenu');
		if ($menu && file_exists($path = XOOPS_ROOT_PATH.'/modules/'.$this->getVar('dirname').'/'.$menu)) {
			include $path;
			$this->adminmenu =& $adminmenu;
		}
	}

	/**
	 * Get the admin menu for the module
	 *
	 * @return	string
	 */
	function &getAdminMenu()
	{
		if ( !isset($this->adminmenu) ) {
			$this->loadAdminMenu();
		}
		return $this->adminmenu;
	}

	/**
	 * Load the module info for this module
	 *
	 * @param	string	$dirname	Module directory
	 * @param	bool	$verbose	Give an error on fail?
	 */
	function loadInfo($dirname, $verbose = true)
	{
		global $xoopsConfig;
		
		//
		// Guard multiplex loading.
		//
		if (!empty($this->modinfo)) {
			return;
		}
		
		$root =& Root::getSingleton();
		$root->mLanguageManager->loadModinfoMessageCatalog($dirname);
		
		if (file_exists(XOOPS_ROOT_PATH.'/modules/'.$dirname.'/xoops_version.php')) {
			include XOOPS_ROOT_PATH.'/modules/'.$dirname.'/xoops_version.php';
		} else {
			if (false != $verbose) {
				echo "Module File for $dirname Not Found!";
			}
			return;
		}
		
		$this->modinfo =& $modversion;
		
		if (isset($this->modinfo['version'])) {
			$this->modinfo['version'] = (float)$this->modinfo['version'];
		} else {
			$this->modinfo['version'] = 0;
		}
	}

	/**
	 * Search contents within a module
	 *
	 * @param	string	$term
	 * @param	string	$andor	'AND' or 'OR'
	 * @param	integer $limit
	 * @param	integer $offset
	 * @param	integer $userid
	 * @return	mixed	Search result.
	 **/
	function &search($term = '', $andor = 'AND', $limit = 0, $offset = 0, $userid = 0)
	{
		$ret = false;
		if ($this->getVar('hassearch') != 1) {
			return $ret;
		}
		$search =& $this->getInfo('search');
		if ($this->getVar('hassearch') != 1 || !isset($search['file']) || !isset($search['func']) || $search['func'] == '' || $search['file'] == '') {
			return $ret;
		}
		if (file_exists(XOOPS_ROOT_PATH."/modules/".$this->getVar('dirname').'/'.$search['file'])) {
			include_once XOOPS_ROOT_PATH.'/modules/'.$this->getVar('dirname').'/'.$search['file'];
		} else {
			return $ret;
		}
		if (function_exists($search['func'])) {
			$func = $search['func'];
			$ret = $func($term, $andor, $limit, $offset, $userid);
		}
		return $ret;
	}

	/**
	 * @return string
	 */
	function getRenderedVersion()
	{
		return sprintf('%01.2f', $this->getVar('version') / 100);
	}

	/**
	 * @return bool
	 */
	function hasHelp()
	{
		$info =& $this->getInfo();
		if (isset($info['cube_style']) && $info['cube_style'] != false && isset($info['help']) && strlen($info['help']) > 0) {
			return true;
		}
		
		return false;
	}

	/**
	 * @return string
	 */
	function getHelp()
	{
		if ($this->hasHelp()) {
			return $this->modinfo['help'];
		}

		return null;
	}
	
	/**
	 * @return bool
	 */
	function hasNeedUpdate()
	{
		$info =& $this->getInfo();
		return ($this->getVar('version') < Xcore_Utils::convertVersionFromModinfoToInt($info['version']));
	}
	
	/**#@+
	 * For backward compatibility only!
	 * @deprecated
	 */
	function mid()
	{
		return $this->getVar('mid');
	}
	function dirname()
	{
		return $this->getVar('dirname');
	}
	function name()
	{
		return $this->getVar('name');
	}
	function &getByDirName($dirname)
	{
		$modhandler = xoops_gethandler('module');
		$ret =& $modhandler->getByDirname($dirname);
		return $ret;
	}
	/**#@-*/
}
