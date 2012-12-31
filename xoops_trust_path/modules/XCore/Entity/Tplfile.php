<?php


namespace XCore\Entity;

use XCore\Entity\Object;

class Tplfile extends Object
{

	function __construct()
	{
		static $initVars;
		if (isset($initVars)) {
		    $this->vars = $initVars;
		    return;
		}
		parent::__construct();
		$this->initVar('tpl_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('tpl_refid', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('tpl_tplset', XOBJ_DTYPE_OTHER, null, false);
		$this->initVar('tpl_file', XOBJ_DTYPE_TXTBOX, null, true, 100);
		$this->initVar('tpl_desc', XOBJ_DTYPE_TXTBOX, null, false, 100);
		$this->initVar('tpl_lastmodified', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('tpl_lastimported', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('tpl_module', XOBJ_DTYPE_OTHER, null, false);
		$this->initVar('tpl_type', XOBJ_DTYPE_OTHER, null, false);
		$this->initVar('tpl_source', XOBJ_DTYPE_SOURCE, null, false);
		$initVars = $this->vars;
	}

	function &getSource()
	{
        $ret =& $this->getVar('tpl_source');
        return $ret;
	}

	function getLastModified()
	{
		return $this->getVar('tpl_lastmodified');
	}
}
