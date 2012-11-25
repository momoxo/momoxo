<?php

/**
 * Class that represents a guest user
 * @author Kazumi Ono <onokazu@xoops.org>
 * @copyright copyright (c) 2000-2003 XOOPS.org
 * @package kernel
 */
class XoopsGuestUser extends XoopsUser
{
	/**
	 * check if the user is a guest user
     *
     * @return bool returns true
     *
     */
	function isGuest()
	{
		return true;
	}
	
	function getGroups($dummy = false)
	{
		return XOOPS_GROUP_ANONYMOUS;
	}
}
