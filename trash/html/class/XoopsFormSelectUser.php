<?php

/**
 * A select field with a choice of available users
 * 
 * @package     kernel
 * @subpackage  form
 * 
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class XoopsFormSelectUser extends XoopsFormSelect
{
	/**
	 * Constructor
	 * 
	 * @param	string	$caption	
	 * @param	string	$name
	 * @param	bool	$include_anon	Include user "anonymous"?
	 * @param	mixed	$value	    	Pre-selected value (or array of them).
	 * @param	int		$size	        Number or rows. "1" makes a drop-down-list.
     * @param	bool    $multiple       Allow multiple selections?
	 */
	function XoopsFormSelectUser($caption, $name, $include_anon=false, $value=null, $size=1, $multiple=false)
	{
	    $this->XoopsFormSelect($caption, $name, $value, $size, $multiple);
		$member_handler =& xoops_gethandler('member');
		if ($include_anon) {
			global $xoopsConfig;
			$this->addOption(0, $xoopsConfig['anonymous']);
		}
		$this->addOptionArray($member_handler->getUserList());
	}
}
