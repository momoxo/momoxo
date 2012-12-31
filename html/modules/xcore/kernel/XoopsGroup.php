<?php

/**
 * a group of users
 * 
 * @copyright copyright (c) 2000-2003 XOOPS.org
 * @author Kazumi Ono <onokazu@xoops.org> 
 * @package kernel
 */
class XoopsGroup extends XoopsObject
{
    /**
     * constructor 
     */
    function __construct()
    {
        static $initVars;
        if (isset($initVars)) {
            $this->vars = $initVars;
	    return;
	}
        parent::__construct();
        $this->initVar('groupid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 100);
        $this->initVar('description', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('group_type', XOBJ_DTYPE_OTHER, null, false);
        $initVars = $this->vars;
    }
}
