<?php

/**
 * A select field with a choice of available groups
 * 
 * @package     kernel
 * @subpackage  form
 * 
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
use XCore\Database\Criteria;

class XoopsFormSelectGroup extends XoopsFormSelect
{
	/**
	 * Constructor
	 * 
	 * @param	string	$caption	
	 * @param	string	$name
	 * @param	bool	$include_anon	Include group "anonymous"?
	 * @param	mixed	$value	    	Pre-selected value (or array of them).
	 * @param	int		$size	        Number or rows. "1" makes a drop-down-list.
     * @param	bool    $multiple       Allow multiple selections?
	 */
	function XoopsFormSelectGroup($caption, $name, $include_anon=false, $value=null, $size=1, $multiple=false)
	{
	    $this->XoopsFormSelect($caption, $name, $value, $size, $multiple);
		$member_handler =& xoops_gethandler('member');
		if (!$include_anon) {
			$this->addOptionArray($member_handler->getGroupList(new Criteria('groupid', XOOPS_GROUP_ANONYMOUS, '!=')));
		} else {
			$this->addOptionArray($member_handler->getGroupList());
		}
	}
}
