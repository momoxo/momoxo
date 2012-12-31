<?php

/**
 * A Config-Option
 * 
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 * 
 * @package     kernel
 */
class XoopsConfigOption extends XoopsObject
{
    /**
     * Constructor
     */
    function __construct()
    {
        static $initVars;
        if (isset($initVars)) {
            $this->vars = $initVars;
            return;
        }
        parent::__construct();
        $this->initVar('confop_id', XOBJ_DTYPE_INT, null);
        $this->initVar('confop_name', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('confop_value', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('conf_id', XOBJ_DTYPE_INT, 0);
        $initVars = $this->vars;
    }

    /**
     * Get a constract of confop_value
     */
    function getOptionKey()
    {
		return defined($this->get('confop_value')) ? constant($this->get('confop_value')) : $this->get('confop_value');
	}
	
    /**
     * Get a constract of confop_name
     */
	function getOptionLabel()
	{
		return defined($this->get('confop_name')) ? constant($this->get('confop_name')) : $this->get('confop_name');
	}
	/**
	 * Compare with contents of $config object. If it's equal, return true.
	 * This member function doesn't use 'conf_id' & 'conf_order' to compare.
	 * 
	 * @param XoopsConfigItem $config
	 * @return bool
	 */
	function isEqual(&$option)
	{
		$flag = true;
		
		$flag &= ($this->get('confop_name') == $option->get('confop_name'));
		$flag &= ($this->get('confop_value') == $option->get('confop_value'));
		
		return $flag;
	}
}
