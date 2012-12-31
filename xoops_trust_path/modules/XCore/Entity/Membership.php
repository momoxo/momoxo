<?php


namespace XCore\Entity;

/**
 * membership of a user in a group
 * 
 * @author Kazumi Ono <onokazu@xoops.org>
 * @copyright copyright (c) 2000-2003 XOOPS.org
 * @package kernel
 */
use XCore\Entity\Object;

class Membership extends Object
{
    /**
     * constructor 
     */
    function __construct()
    {
        parent::__construct();
        $this->initVar('linkid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('groupid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
    }
}
