<?php

/**
 * A selection box with options for matching search terms.
 * 
 * @package     kernel
 * @subpackage  form
 * 
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class XoopsFormSelectMatchOption extends XoopsFormSelect
{
	/**
	 * Constructor
	 * 
	 * @param	string	$caption
	 * @param	string	$name
	 * @param	mixed	$value	Pre-selected value (or array of them). 
	 * 							Legal values are {@link XOOPS_MATCH_START}, {@link XOOPS_MATCH_END}, 
	 * 							{@link XOOPS_MATCH_EQUAL}, and {@link XOOPS_MATCH_CONTAIN}
	 * @param	int		$size	Number of rows. "1" makes a drop-down-list
	 */
	function XoopsFormSelectMatchOption($caption, $name, $value=null, $size=1)
	{
		$this->XoopsFormSelect($caption, $name, $value, $size, false);
		$this->addOption(XOOPS_MATCH_START, _STARTSWITH);
		$this->addOption(XOOPS_MATCH_END, _ENDSWITH);
		$this->addOption(XOOPS_MATCH_EQUAL, _MATCHES);
		$this->addOption(XOOPS_MATCH_CONTAIN, _CONTAINS);
	}
}
