<?php


namespace XCore\Entity;

/**
 * A category of configs
 * 
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 * 
 * @package     kernel
 */
use XCore\Entity\Object;

class ConfigCategory extends Object
{
    /**
     * Constructor
     * 
     */
    function __construct()
    {
        parent::__construct();
        $this->initVar('confcat_id', XOBJ_DTYPE_INT, null);
        $this->initVar('confcat_name', XOBJ_DTYPE_OTHER, null);
        $this->initVar('confcat_order', XOBJ_DTYPE_INT, 0);
    }

    /**
     * Get a constract of name
     */
    function getName()
    {
		return defined($this->get('confcat_name')) ? constant($this->get('confcat_name')) : $this->get('confcat_name');
	}
}
