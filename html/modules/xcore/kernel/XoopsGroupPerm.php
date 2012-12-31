<?php

/**
 * A group permission
 * 
 * These permissions are managed through a {@link XoopsGroupPermHandler} object
 * 
 * @package     kernel
 * 
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class XoopsGroupPerm extends XoopsObject
{

    /**
     * Constructor
     * 
     */
    function __construct()
    {
	static $initVars;
        if (isset($initVars)) {
            $this->vars = $initVars;
            return;
        }
        parent::__construct();
        $this->initVar('gperm_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('gperm_groupid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('gperm_itemid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('gperm_modid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('gperm_name', XOBJ_DTYPE_OTHER, null, false);
        $initVars = $this->vars;
    }
    
    function cleanVars()
    {
    	if (!parent::cleanVars()) {
    		return false;
    	}
    	
    	// The following validation code doesn't have this class,
    	// because the validation code accesses handlers.
    	// But, this follows traditional architecture of XOOPS2.
    	
    	$gHandler = xoops_gethandler('group');
    	$group =& $gHandler->get($this->get('gperm_groupid'));
    	if (!is_object($group)) {
    		return false;
    	}

    	$mHandler = xoops_gethandler('module');
    	
    	if ($this->get('gperm_modid') != 1) {
			$module =& $mHandler->get($this->get('gperm_modid'));
			if (!is_object($module)) {
				return false;
			}
    	}
    	
    	if ($this->get('gperm_name') == GROUPPERM_VAL_MODREAD
    	    || $this->get('gperm_name') == GROUPPERM_VAL_MODADMIN)
    	{
    		$mHandler = xoops_gethandler('module');
    		$module =& $mHandler->get($this->get('gperm_itemid'));
    		if (!is_object($module)) {
    			return false;
	    	}
    	}
    	else if ($this->get('gperm_name') == GROUPPERM_VAL_BLOCKREAD) {
    		$bHandler = xoops_gethandler('block');
    		$block =& $bHandler->get($this->get('gperm_itemid'));
    		if (!is_object($block)) {
    			return false;
	    	}
    	}
    	
    	return true;
    }
}
